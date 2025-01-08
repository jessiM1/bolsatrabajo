<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'conexion.php';
require_once 'fpdf/fpdf.php'; // Incluir la librería FPDF

$correo = $_SESSION['correo'];
if (!isset($_SESSION['correo'])) {
    header('Location: login.php'); // Redirigir al login si no está autenticado
    exit();
}

$query = "SELECT * FROM buscadores WHERE correo='$correo'";
$resultado = $conn->query($query);

$idBuscador = '';
while ($fila = mysqli_fetch_assoc($resultado)) {
    $idBuscador = $fila['id_buscador'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar datos del formulario
	$cargo = $_POST['cargo'];
    $id_buscador = $_POST['id_b'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $sobreMi = $_POST['sobreMi'];
	$habilidades_b = $_POST['habilidades_b'];
    $empresa = $_POST['empresa']; // Array de empresas
    $puesto = $_POST['puesto'];   // Array de puestos
    $duracion = $_POST['duracion']; // Array de duraciones
    $institucion = $_POST['institucion']; // Array de instituciones
    $titulo = $_POST['titulo'];    // Array de títulos
    $fecha = $_POST['fecha'];     // Array de fechas de graduación
    $foto = $_FILES['foto'];      // Foto de perfil

    if ($foto['error'] === UPLOAD_ERR_OK) {
        // Definir la carpeta donde se guardarán las imágenes
        $carpetaDestino = 'guardadas/';
        // Obtener el nombre del archivo
        $nombreArchivo = basename($foto['name']);
        $rutaArchivo = $carpetaDestino . $nombreArchivo;

        // Mover la foto a la carpeta "guardadas"
        if (move_uploaded_file($foto['tmp_name'], $rutaArchivo)) {
            // Leer el contenido del archivo y convertirlo en un BLOB
            $imagen = file_get_contents($rutaArchivo);

            // Insertar datos personales en la base de datos
           $query = "INSERT INTO informacion_personal (id_buscador, cargo, nombre, correo, telefono, sobremi, habilidades_b, imagen, nomimagen) 
          VALUES ('$id_buscador', '$cargo', '$nombre', '$email', '$telefono', '$sobreMi', '$habilidades_b', ?, '$nombreArchivo')";

            $stmt = $conn->prepare($query);
            $stmt->bind_param('b', $imagen);

            if ($stmt->execute()) {
               $idCurriculum = $conn->insert_id;
if (!$idCurriculum) {
    echo "Error al obtener el ID del currículum.";
    exit();
}

				 // Obtener el ID del curriculum recién insertado

     foreach ($empresa as $index => $emp) {
    $emp = $conn->real_escape_string($emp);
    $puestoEmp = $conn->real_escape_string($puesto[$index]);
    $duracionEmp = $conn->real_escape_string($duracion[$index]);

    $queryExperiencia = "INSERT INTO experiencia_laboral (id_info, empresa, puesto, duracion) 
                         VALUES ('$idCurriculum', '$emp', '$puestoEmp', '$duracionEmp')";
    
    if ($conn->query($queryExperiencia)) {
        echo "Experiencia laboral insertada correctamente.<br>";
    } else {
        echo "Error al insertar experiencia laboral: " . $conn->error . "<br>";
    }
}

foreach ($institucion as $index => $inst) {
    $inst = $conn->real_escape_string($inst);
    $tit = $conn->real_escape_string($titulo[$index]);
    $fechaGrado = $conn->real_escape_string($fecha[$index]);

    $queryEducacion = "INSERT INTO formacion_academica (id_info, institucion, titulo, fecha_graduacion) 
                       VALUES ('$idCurriculum', '$inst', '$tit', '$fechaGrado')";
    
    if ($conn->query($queryEducacion)) {
        echo "Formación académica insertada correctamente.<br>";
    } else {
        echo "Error al insertar formación académica: " . $conn->error . "<br>";
    }
}

$queryCv = "SELECT * FROM informacion_personal WHERE id_info='$idCurriculum'";
$cvResult = $conn->query($queryCv);
$cvData = mysqli_fetch_assoc($cvResult);

	$habilidades_b = $cvData['habilidades_b']; 
$habilidades = explode(", ", $habilidades_b); // Si las habilidades están separadas por comas


             $pdf = new FPDF();
$pdf->AddPage();

// Establecer márgenes
$pdf->SetMargins(20, 15, 20);

// Colores personalizados
$headerColor = [0, 0, 0]; // Azul oscuro
$lineColor = [220, 220, 220]; // Gris claro
$sectionBgColor = [245, 245, 245]; // Gris claro de fondo
$textColor = [50, 50, 50]; // Texto negro

// Título del PDF - Centrado
$pdf->SetFont('Arial', 'B', 24);
$pdf->SetTextColor($headerColor[0], $headerColor[1], $headerColor[2]);
$pdf->Cell(0, 10, 'Curriculum Vitae', 0, 1, 'C');
$pdf->Ln(10);

// Imagen del usuario
$nomimagen = $cvData['nomimagen'];
$ext = pathinfo($nomimagen, PATHINFO_EXTENSION);

if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])) {
    $rutaImagen = 'guardadas/' . $nomimagen;
    if (file_exists($rutaImagen)) {
         $pdf->Image($rutaImagen, 160, 10, 30, 20); // Ajustar posición y tamaño
    } else {
        $pdf->Cell(0, 10, 'Imagen no disponible', 0, 1, 'C');
    }
} else {
    $pdf->Cell(0, 10, 'Formato de imagen no válido', 0, 1, 'C');
}

// Información personal
$pdf->SetFillColor($sectionBgColor[0], $sectionBgColor[1], $sectionBgColor[2]);
$pdf->SetTextColor($textColor[0], $textColor[1], $textColor[2]);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Datos Personales', 0, 1, 'L', true);
$pdf->SetDrawColor($lineColor[0], $lineColor[1], $lineColor[2]);
$pdf->SetLineWidth(0.5);
$pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY());
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'Nombre:', 0, 0, 'L');
$pdf->Cell(0, 10, $nombre, 0, 1, 'L');
$pdf->Cell(40, 10, 'Correo:', 0, 0, 'L');
$pdf->Cell(0, 10, $email, 0, 1, 'L');
$pdf->Cell(40, 10, 'Telefono:', 0, 0, 'L');
$pdf->Cell(0, 10, $telefono, 0, 1, 'L');
$pdf->Cell(40, 10, 'Sobre mi:', 0, 0, 'L');
$pdf->MultiCell(0, 10, $sobreMi);
$pdf->Ln(10);

// Habilidades Blandas
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Habilidades Blandas', 0, 1, 'L', true);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, implode("\n", $habilidades));
$pdf->Ln(10);

// Experiencia Laboral
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Experiencia Laboral', 0, 1, 'L', true);
$pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY());
$pdf->Ln(5);

foreach ($empresa as $index => $emp) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, $emp, 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Puesto: ' . $puesto[$index], 0, 1);
    $pdf->Cell(0, 10, 'Duracion: ' . $duracion[$index], 0, 1);
    $pdf->Ln(5);
}

// Formación Académica
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Formacion Academica', 0, 1, 'L', true);
$pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY());
$pdf->Ln(5);

foreach ($institucion as $index => $inst) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, $inst, 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Titulo: ' . $titulo[$index], 0, 1);
    $pdf->Cell(0, 10, 'Fecha: ' . $fecha[$index], 0, 1);
    $pdf->Ln(5);
}


        // Definir el nombre y la ruta de la carpeta donde se guardará el PDF
$nombrePDF = $idCurriculum . '.pdf';
$directorioPDF = 'cv_uploads/'; // Carpeta donde se almacenarán los PDFs


if (!file_exists($directorioPDF)) {
    mkdir($directorioPDF, 0755, true); // Crear la carpeta si no existe
}

// Ruta completa del archivo
$rutaPDF =  $nombrePDF;

// Guardar el PDF en el servidor
$pdf->Output('F', $rutaPDF);

// Insertar la ruta completa del PDF en la base de datos
$queryCV = "INSERT INTO cv (id_info, archivo_pdf) VALUES ('$idCurriculum', '$rutaPDF')";
if ($conn->query($queryCV)) {
    echo "CV generado y guardado exitosamente.";
} else {
    echo "Error al guardar el CV en la base de datos: " . $conn->error;
}

// Redirigir a otra página
header('Location: mis_cvs.php');
exit();

               
            } else {
                echo "Error al guardar el currículum: " . $conn->error;
            }
				
			
        } else {
            echo "Error al mover la foto al directorio.";
        }
    } else {
        echo "No se ha subido ninguna foto o hubo un error en la carga.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>BOL UMB</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- awesome fontfamily -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
    <style>
	button {
  overflow: visible;
}

button, select {
  text-transform: none;
}

button, input, select, textarea {
  color: #5A5A5A;
  font: inherit;
  margin: 0;
}

input {
  line-height: normal;
}

textarea {
  overflow: auto;
}
.parent-container {
    display: flex;
    justify-content: center; /* Centra horizontalmente */
    align-items: center;    /* Centra verticalmente (opcional) */
   
}
.cv-form {
 border: solid 3px #474544;
    min-width: 32.5%; 
    max-width: 32.5%; 
    box-sizing: border-box;
    padding: 10px;
    background-color: #fff;  
    margin-right: 10px;
    border-radius: 8px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
}

form {
  padding: 37.5px;
  margin: 50px 0;
}

h2 {
  color: #474544;
  font-size: 32px;
  font-weight: 700;
  letter-spacing: 7px;
  text-align: center;
  text-transform: uppercase;
}

.underline {
  border-bottom: solid 2px #474544;
  margin: -0.512em auto;
  width: 80px;
}

.icon_wrapper {
  margin: 50px auto 0;
  width: 100%;
}

.icon {
  display: block;
  fill: #474544;
  height: 50px;
  margin: 0 auto;
  width: 50px;
}

input[type='text'], [type='email'], [type='tel'], [type='file'], select, textarea {
  background: none;
  border: none;
  border-bottom: solid 2px #474544;
  color: #474544;
  font-size: 1.000em;
  font-weight: 400;
  letter-spacing: 1px;
  margin: 0em 0 1.875em 0;
  padding: 0 0 0.875em 0;
  text-transform: uppercase;
  width: 100%;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  -ms-box-sizing: border-box;
  -o-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-transition: all 0.3s;
  -moz-transition: all 0.3s;
  -ms-transition: all 0.3s;
  -o-transition: all 0.3s;
  transition: all 0.3s;
}

input[type='text']:focus, [type='email']:focus, [type='file']:focus, textarea:focus {
  outline: none;
  padding: 0 0 0.875em 0;
}

textarea {
  line-height: 150%;
  height: 150px;
  resize: none;
  width: 100%;
}

select {
  background: url('https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-32.png') no-repeat right;
  outline: none;
  -moz-appearance: none;
  -webkit-appearance: none;
}

select::-ms-expand {
  display: none;
}

#form_button {
 display: block;
     background: #8b1310;
     color: #fff;
     max-width: 224px;
     height: 61px;
     padding: 14px 0px;
     width: 100%;
     font-size: 17px;
     text-align: center;
     font-weight: 500;
     transition: ease-in all 0.5s;
}

#form_button:hover {
  background: #fd990c;
     color: #fff;
     transition: ease-in all 0.5s;
}

@media screen and (max-width: 768px) {
  .cv-form {
    margin: 20px auto;
    width: 95%;
  }
}

@media screen and (max-width: 480px) {
  h2 {
    font-size: 26px;
  }
  
  .underline {
    width: 68px;
  }
  
  #form_button {
    padding: 15px 25px;
  }
}

@media screen and (max-width: 420px) {
  h2 {
    font-size: 18px;
  }
  
  .icon {
    height: 35px;
    width: 35px;
  }
  
  .underline {
    width: 53px;
  }
  
  input[type='text'], [type='email'], select, textarea {
    font-size: 0.875em;
  }
}
.breadcrumbs {
  border: 1px solid #cbd2d9;
  border-radius: 0.3rem;
  display: inline-flex;
  overflow: hidden;
}

.breadcrumbs__item {
  background: #fff;
  color: #333;
  outline: none;
  padding: 0.75em 0.75em 0.75em 1.25em;
  position: relative;
  text-decoration: none;
  transition: background 0.2s linear;
}

.breadcrumbs__item:hover:after,
.breadcrumbs__item:hover {
  background: #edf1f5;
}

.breadcrumbs__item:focus:after,
.breadcrumbs__item:focus,
.breadcrumbs__item.is-active:focus {
  background: #323f4a;
  color: #fff;
}

.breadcrumbs__item:after,
.breadcrumbs__item:before {
  background: white;
  bottom: 0;
  clip-path: polygon(50% 50%, -50% -50%, 0 100%);
  content: "";
  left: 100%;
  position: absolute;
  top: 0;

  transition: background 0.2s linear;
  width: 1em;
  z-index: 1;
}

.breadcrumbs__item:before {
  background: #cbd2d9;
  margin-left: 1px;
}

.breadcrumbs__item:last-child {
  border-right: none;
}

.breadcrumbs__item.is-active {
  background: #edf1f5;
}


#notificaciones-container {
    width: 300px;
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    padding: 10px;
    position: absolute;
    top: 50px; /* ajusta según sea necesario */
    right: 10px;
    z-index: 1000;
    display: none;
}

#notificaciones-list {
    max-height: 300px;
    overflow-y: auto;
}

.notificacion {
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

.notificacion h6 {
    margin: 0;
    font-size: 14px;
}

.notificacion small {
    font-size: 12px;
    color: #777;
}

.marcar-leida-btn {
    display: block;
     background: #8b1310;
     color: #fff;
     max-width: 150px;
     height: 50px;
     padding: 14px 0px;
     width: 100%;
     font-size: 17px;
     text-align: center;
     font-weight: 500;
     transition: ease-in all 0.5s;
}

.marcar-leida-btn:hover {
     background: #fd990c;
     color: #fff;
     transition: ease-in all 0.5s;
}

   </style>
   <!-- body -->
  <body class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="" /></div>
      </div>
      <!-- end loader -->
      <div id="mySidepanel" class="sidepanel">
         <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
         <a href="index.php">INICIO</a>
         <a href="login.php">LOGIN</a>
         <a href="registroempresa.php">REGISTRO EMPRESA</a>
         <a href="registro.php">REGISTRO USUARIO</a>
      </div>
      <!-- header -->
      <header>
         <!-- header inner -->
         <div class="head-top">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-3">
                     <div class="logo">
                        <a href="index.php"><img src="images/bol.png" height="500" width="90" /></a>
                     </div>
                  </div>
                  <div class="col-sm-9">
                     <ul class="email text_align_right">
                      
                        <li class="d_none"> <a href="bienvenidousu.php">Inicio <i  aria-hidden="true"></i></a> </li>
                         
                          <li class="d_none"> <a href="mis_cvs.php">Ver mis CV <i  aria-hidden="true"></i></a> </li>
                         <li class="d_none"> <a href="miperfil.php">Mi Perfil<i  aria-hidden="true"></i></a> </li>
                        
                            <li class="d_none"> 
    <a href="javascript:void(0);" id="notificaciones-toggle"> <i class="fas fa-bell"></i></a>
</li>
 <li class="d_none"> <a href="logout.php">Cerrar Sesión<i  aria-hidden="true"></i></a> </li>

<div id="notificaciones-container" style="display:none;"> 
    <h1><center>Notificaciones</center></h1>
    <div id="notificaciones-list">
        <!-- notificaciones dinámicamente -->    
    </div>
</div>

                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </header>
     
      <!-- services -->
         <div class="services_main">
         <div class="container">
         <div class="row">

          
           <div class="titlepage">
                  <div class="parent-container">
                  <div class="cv-form">
        <h2>Crear Currículum Vitae</h2>

       <form method="POST" action="" enctype="multipart/form-data">
 
                         <fieldset>
                         <legend><center>Información Personal</center></legend>

                         </fieldset>

                         <label for="cargo">Cargo:</label>
                            <input type="text" id="cargo" name="cargo"  required  >
                               
                            <input type="hidden" name="id_b" value="<?php echo $idBuscador; ?>">
                            <label for="nombre">Nombre Completo:</label>
                                   <input type="text" id="nombre" name="nombre" required  >
                               
                             
                             <label for="email">Correo Electrónico:</label>
                             
                          <input type="email" id="email" name="email"  required > 
                               
                            
                            
                                <label for="telefono">Teléfono:</label>

                                  <input type="tel" id="telefono" name="telefono"  required > 
                            
                              <label for="sobreMi">Sobre mí:</label>
                                <textarea id="sobreMi" name="sobreMi" rows="4" required ></textarea>
                               
                            
                            <label for="habilidades_b">Habilidades Blandas:</label>

                                 <textarea id="habilidades_b" name="habilidades_b" rows="4"  ></textarea>

                               
                            
                            <label for="foto">Foto de Perfil:</label>
                                <input type="file" name="foto"  accept="image/*">  
                               </fieldset>
                             <fieldset>
                             <br>
                <legend><center>Experiencia Laboral</center></legend>
               </fieldset> 

                             
                               <button type="button"  onclick="agregarExperiencia()"><img src="images/mas.png" height="30" width="30"></button>
            <div id="experienciaContainer"></div>
                                
                             <br>
                            <fieldset>
                <legend><center>Formación Académica</center></legend>
</fieldset>
                             
                            
                                <button type="button"  onclick="agregarEducacion()"><img src="images/mas.png" height="30" width="30"></button>
            <div id="educacionContainer"></div>

                                
                            <br>
                           <center> <button type="submit" class="read_more" id="form_button">Generar y Guardar CV</button></center>
    </form>
    </div>
</div>

       
                  </div>
               </div>
            </div>
         </div>
      </div>
                    
      <!-- end services -->
      <!-- footer -->
      <!-- footer -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class="col-md-10 offset-md-1">
                     <ul class="social_icon text_align_center">
                        
                     </ul>
                  </div>
                  <div class="col-md-4 col-sm-6">
                     <div class="reader">
                        <a href="index.html"><img src="images/bol.png" height="250" width="250"/></a>
                       
                     </div>
                  </div>
                  <div class="col-md-2 col-sm-6">
                     <div class="reader">
                        <h3>Explora</h3>
                        <ul class="xple_menu">
                           <li><a href="index.php">Inicio</a></li>
                           <li><a href="login.php">Login</a></li>
                           <li><a href="registroempresa.php">Registro Empresa</a></li>
                           <li><a href="registro.php">Registro Usuario</a></li>
                        </ul>
                     </div>
                  </div>
                 
                  <div class="col-md-3 col-sm-6">
                     <div class="reader">
                      
                       
                     </div>
                  </div>
               </div>
            </div>
            <div class="copyright text_align_center">
               <div class="container">
                  <div class="row">
                     <div class="col-md-10 offset-md-1">
                        <p>Copyright 2024 By <a href="https://html.design/"> Bol UMB</a></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- end footer -->
      <!-- Javascript files-->
      
<script>
    function agregarExperiencia() {
        const experienciaContainer = document.getElementById('experienciaContainer');
        const idUnico = `exp-${Date.now()}`; // Generar un ID único para la experiencia
        const nuevaExperiencia = `
            
			<div class="experiencia" id="${idUnico}">
                 <label for="empresa">Empresa:</label>
                <input type="text"    name="empresa[]" required>
				 <label for="puesto">Puesto:</label>
                <input type="text"   name="puesto[]" required>
                <label for="duracion">Duración:</label>
                <input type="text" name="duracion[]" required>
                <button type="button"  onclick="quitarElemento('${idUnico}')"><img src="images/menos.png"  height="35" width="35"></button>
            </div>
        `;
        experienciaContainer.insertAdjacentHTML('beforeend', nuevaExperiencia);
    }

    function agregarEducacion() {
        const educacionContainer = document.getElementById('educacionContainer');
        const idUnico = `edu-${Date.now()}`; // Generar un ID único para la educación
        const nuevaEducacion = `
            <div class="educacion" id="${idUnico}">
                <label for="institucion">Institución:</label>
                <input type="text"  name="institucion[]" required>
                 <label for="titulo">Título:</label>
                <input type="text"  name="titulo[]" required>
                 <label for="fecha">Fecha:</label>
                <input type="date" name="fecha[]" required>
				<br>
                <button type="button" onclick="quitarElemento('${idUnico}')"><img src="images/menos.png" height="35" width="35"></button>
            </div>
        `;
        educacionContainer.insertAdjacentHTML('beforeend', nuevaEducacion);
    }

    function quitarElemento(id) {
        const elemento = document.getElementById(id);
        if (elemento) {
            elemento.remove();
        }
    }
</script>
 <script>
   document.getElementById('notificaciones-toggle').addEventListener('click', function() {
    const container = document.getElementById('notificaciones-container');
    // Cambiar la visibilidad del contenedor
    container.style.display = (container.style.display === 'none' || container.style.display === '') ? 'block' : 'none';
});

async function cargarNotificaciones() {
    try {
        const response = await fetch('phpobtenernotificaciones.php');
        const data = await response.json();
        const notificacionesList = document.getElementById('notificaciones-list');
        notificacionesList.innerHTML = ''; // Limpiar notificaciones anteriores

        if (data.length > 0) {
            data.forEach(notificacion => {
                const div = document.createElement('div');
                div.classList.add('notificacion');
                div.innerHTML = `
                    <h6>${notificacion.mensaje}</h6>
                    <small>${new Date(notificacion.fecha).toLocaleString('es-ES', { dateStyle: 'short', timeStyle: 'short' })}</small>
                    <button class="marcar-leida-btn" data-id="${notificacion.id_notificacion}" style="display: block; margin: 0 auto;">
                        Marcar como leída
                    </button>
                `;
                notificacionesList.appendChild(div);
            });

            // Agregar eventos a los botones "Marcar como leída"
            document.querySelectorAll('.marcar-leida-btn').forEach(boton => {
                boton.addEventListener('click', async () => {
                    const idNotificacion = boton.getAttribute('data-id');
                    await marcarNotificacionLeida(idNotificacion);
                });
            });
        } else {
            notificacionesList.innerHTML = '<h6>No tienes notificaciones nuevas.</h6>';
        }
    } catch (error) {
        console.error('Error al cargar notificaciones:', error);
        const notificacionesList = document.getElementById('notificaciones-list');
        notificacionesList.innerHTML = '<h6>Error al cargar las notificaciones.</h6>';
    }
}

async function marcarNotificacionLeida(idNotificacion) {
    try {
        const response = await fetch('phpmarcarleida.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id_notificacion: idNotificacion })
        });

        const data = await response.json();
        if (data.success) {
            alert('La notificación fue marcada como leída.');
            cargarNotificaciones(); // Recargar notificaciones
        } else {
            console.error('Error al marcar como leída:', data.error);
        }
    } catch (error) {
        console.error('Error al enviar la solicitud:', error);
    }
}

// Llamar la función al cargar la página
document.addEventListener('DOMContentLoaded', cargarNotificaciones);

// Actualizar notificaciones cada 30 segundos
setTimeout(function actualizarNotificaciones() {
    cargarNotificaciones();
    setTimeout(actualizarNotificaciones, 30000);
}, 30000);

</script>

      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
       <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
   </body>
</html>
