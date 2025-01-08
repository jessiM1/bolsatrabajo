<?php
session_start();
require_once 'conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['correo'])) {
    header('Location: login.php'); // Redirigir al login si no está autenticado
    exit();
}

$correo = $_SESSION['correo'];


// Obtener el ID del buscador a partir del correo
$query = "SELECT id_buscador FROM buscadores WHERE correo='$correo'";
$resultado = $conn->query($query);
$idBuscador = '';

if ($resultado && $fila = $resultado->fetch_assoc()) {
    $idBuscador = $fila['id_buscador'];
} else {
    echo "No se encontró el buscador.";
    exit();
}
// Obtener los datos del CV actual
$queryCv = "SELECT * FROM informacion_personal ";
$cvResult = $conn->query($queryCv);



$queryExperiencia = "SELECT * FROM experiencia_laboral ";
$experienciaResult = $conn->query($queryExperiencia);


$queryEducacion = "SELECT * FROM formacion_academica";
$educacionResult = $conn->query($queryEducacion);




// Obtener criterios de búsqueda si existen
$criterio = isset($_GET['buscar']) ? $_GET['buscar'] : '';

// Ajustar la consulta para incluir la búsqueda por nombre o cargo
$queryCVs = "SELECT c.id_info, c.archivo_pdf, i.nombre, i.cargo,i.correo,i.habilidades_b,i.telefono,i.sobremi,i.nomimagen
             FROM cv c 
             JOIN informacion_personal i ON c.id_info = i.id_info 
             WHERE i.id_buscador = '$idBuscador'
			 ";

if (!empty($criterio)) {
    $criterio = $conn->real_escape_string($criterio); // Sanitizar el valor de búsqueda
    $queryCVs .= " AND (i.nombre LIKE '%$criterio%' OR i.cargo LIKE '%$criterio%')";
}
$resultadoCVs = $conn->query($queryCVs);

if (isset($_GET['accion'], $_GET['id']) && $_GET['accion'] === 'eliminar1') {
    $idInfo = intval($_GET['id']); // Sanitizar el ID recibido

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // Verificar si el CV pertenece al usuario
        $queryVerificar = "SELECT i.id_info 
                           FROM informacion_personal i 
                           JOIN buscadores b ON i.id_buscador = b.id_buscador 
                           WHERE i.id_info = ? AND b.correo = ?";
        $stmt = $conn->prepare($queryVerificar);
        $stmt->bind_param('is', $idInfo, $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Eliminar registros relacionados
            $queries = [
                "DELETE FROM cv WHERE id_info = ?",
                "DELETE FROM informacion_personal WHERE id_info = ?",
                "DELETE FROM experiencia_laboral WHERE id_info = ?",
                "DELETE FROM formacion_academica WHERE id_info = ?"
            ];

            foreach ($queries as $query) {
                $stmt = $conn->prepare($query);
                $stmt->bind_param('i', $idInfo);
                if (!$stmt->execute()) {
                    throw new Exception('Error al eliminar registros.');
                }
            }

            // Confirmar transacción
            $conn->commit();
            echo "<script>alert('CV eliminado correctamente.');</script>";
        } else {
            echo "<script>alert('No tienes permiso para eliminar este CV.');</script>";
        }
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        $conn->rollback();
        echo "<script>alert('Error al eliminar el CV: {$e->getMessage()}');</script>";
    } finally {
        $stmt->close();
    }
	header('Location: mis_cvs.php');

    exit();
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







form {
  padding: 37.5px;
  margin: 50px 0;
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




input[type='text'], [type='email'], [type='tel'],[type='date'], select, textarea {
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

input[type='text']:focus, [type='email']:focus, [type='date']:focus, textarea:focus {
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

#form_button2 {
  display: block;
     background: #8b1310;
     color: #fff;
     max-width: 224px;
     height: 80px;
     padding: 14px 0px;
     width: 100%;
     font-size: 17px;
     text-align: center;
     font-weight: 500;
     transition: ease-in all 0.5s;
}

#form_button2:hover {
  background: #fd990c;
  color: #F2F3EB;
}


@media screen and (max-width: 768px) {
  .cv-form {
    margin: 20px auto;
    width: 95%;
  }
}

@media screen and (max-width: 480px) {
 
  
  .underline {
    width: 68px;
  }
  
  #form_button {
    padding: 15px 25px;
  }
}

@media screen and (max-width: 420px) {

  
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
  top:-226px;
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


.cv-container {
    position: relative;
    width: 80%; /* Ajusta el tamaño del contenedor para que sea más pequeño */
    overflow: hidden; /* Para ocultar los elementos fuera de la vista */
    margin: 0 auto; /* Centra el contenedor */
}

.cv-slider {
    display: flex;
    transition: transform 0.3s ease-in-out; /* Para deslizar el contenido */
}

.cv-card {
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

.cv-card h2 {
    font-size: 18px; /* Reducir tamaño del título */
}

.cv-card form {
    font-size: 14px; /* Reducir el tamaño de los inputs y los botones */
}

.slider-button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
   
    padding: 10px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

#prevButton {
    left: 10px;
}

#nextButton {
    right: 10px;
}

/* Reducir el tamaño de los inputs y los botones 
form input[type="text"]
{
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 2px solid #ddd;
    border-radius: 5px;
    font-family: 'Raleway', sans-serif;
    font-size: 14px;
    color: #333;
    background-color: #f9f9f9;
    transition: all 0.3s ease-in-out;
}

form input[type="text"]:focus {
    border-color: #fe9a0c;
    background-color: #fff;
    box-shadow: 0 0 5px rgba(254, 154, 12, 0.5);
    outline: none;
}

.filtros_busqueda form {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
}

.filtros_busqueda .col-md-3 {
    flex: 1 1 18%; 
    min-width: 150px; 
}

.filtros_busqueda .col-md-12 {
    flex: 1 1 100%;
    text-align: center;
}
*/

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
                         <li class="d_none"> <a href="cv.php">Crear CV <i  aria-hidden="true"></i></a> </li>
                         
                         <li class="d_none"> <a href="miperfil.php">Mi Perfil<i  aria-hidden="true"></i></a> </li>
                                                 <li class="d_none"> 
    <a href="javascript:void(0);" id="notificaciones-toggle"> <i class="fas fa-bell"></i></a>
</li>
 <li class="d_none"> <a href="logout.php">Cerrar Sesión<i  aria-hidden="true"></i></a> </li>

<div id="notificaciones-container" style="display:none;"> 
    <h2><center>Notificaciones</center></h2>
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
               <div class="col-md-12">
                  <div class="titlepage">
                  
                  <center><h2>Mis CV</h2></center>
                  <section class="vacantes_section layout_padding">
    <div class="container">
     
    
        <!-- Barra de búsqueda y filtros -->
  <div class="filtros_busqueda">
    <form method="GET" lass="form-horizontal" action="">

                <input type="text"  name="buscar" placeholder="Buscar por Nombre o Cargo"  style=" text-align:center" value="<?php echo htmlspecialchars($criterio); ?>" 
/>

 
                <button type="submit" class="read_more" style="display: block; margin: 0 auto;">Buscar</button>
    </form>
</div>
 <br>

<div class="cv-container">
    <div id="cvSlider" class="cv-slider">
 <?php if ($resultadoCVs && $resultadoCVs->num_rows > 0): ?>
            <?php while ($cvData = $resultadoCVs->fetch_assoc()): ?>
 
    <div class="cv-card">
          <h2><center>Currículum Vitae</center></h2>

        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_b" value="<?php echo $idBuscador; ?>">
            <input type="hidden" name="id_cv" value="<?php echo $id_cv; ?>">
            <input type="hidden" name="id_cv" value="<?php echo $cvData['id_info']; ?>">


            <!-- Información Personal -->
            <fieldset>
                <label for="foto">Foto de Perfil:</label>
                <br>
                <center><img src="guardadas/<?php echo $cvData['nomimagen']; ?>" alt="<?php echo $cvData['nomimagen']; ?>" height="200px" width="200px" style="border-radius:100px"></center>
                <br>

                <legend><center>Información Personal</center></legend>
                <br>
                <label for="cargo">Cargo:</label>
                <input type="text" id="cargo" name="cargo" value="<?php echo $cvData['cargo']; ?>" required readonly>

                <label for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $cvData['nombre']; ?>" required readonly>

                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo $cvData['correo']; ?>" required readonly>

                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" value="<?php echo $cvData['telefono']; ?>" required readonly>

                <label for="sobreMi">Sobre mí:</label>
                <textarea id="sobreMi" name="sobreMi" rows="4" required readonly><?php echo $cvData['sobremi']; ?></textarea>

                <label for="habilidades_b">Habilidades Blandas:</label>
                <textarea id="habilidades_b" name="habilidades_b" rows="4" required readonly ><?php echo $cvData['habilidades_b']; ?></textarea>
            </fieldset>

<br>

            <!-- Experiencia Laboral -->
            <fieldset>
                <legend><center>Experiencia Laboral</center></legend>
                <div id="experienciaContainer">
                    <?php
                    $queryExperiencia = "SELECT * FROM experiencia_laboral WHERE id_info = " . $cvData['id_info'];
                    $experienciaResult = $conn->query($queryExperiencia);
                    while ($experiencia = $experienciaResult->fetch_assoc()) {
                        echo '<div class="experiencia">
                            <input type="hidden" name="id_ex[]" value="'.$experiencia['id_ex'].'">
                            <label for="Empresa">Empresa:</label>
                            <input readonly type="text" name="empresa[]" value="'.$experiencia['empresa'].'" required>
                            <label for="Puesto">Puesto:</label>
                            <input readonly type="text" name="puesto[]" value="'.$experiencia['puesto'].'" required>
                            <label for="duracion">Duración:</label>
                            <input  readonly type="text" name="duracion[]" value="'.$experiencia['duracion'].'" required>
                        </div>';
                    }
                    ?>
                </div>
            </fieldset>
<br>
            <!-- Formación Académica -->
            <fieldset>
                <legend><center>Formación Académica</center></legend>
                <div id="educacionContainer">
                    <?php
                    $queryEducacion = "SELECT * FROM formacion_academica WHERE id_info = " . $cvData['id_info'];
                    $educacionResult = $conn->query($queryEducacion);
                    while ($educacion = $educacionResult->fetch_assoc()) {
                        echo '<div class="educacion">
                            <input readonly  type="hidden" name="id_e[]" value="'.$educacion['id'].'">
                            <label for="Institucion">Institución:</label>
                            <input  readonly type="text" name="institucion[]" value="'.$educacion['institucion'].'" required>
                            <label for="Titulo">Título:</label>
                            <input readonly type="text" name="titulo[]" value="'.$educacion['titulo'].'" required>
                            <label for="Fecha de graduacion">Fecha de graduación:</label>
                            <input readonly type="date" name="fecha[]" value="'.$educacion['fecha_graduacion'].'" required>
                        </div>';
                    }
                    ?>
                </div>
            </fieldset>
        </form>

        <form action="modificarcv.php?id=<?php echo $cvData['id_info']; ?>" method="POST">
            <center><button type="submit" id="form_button2"><img src="images/editar.png" height="50" width="50">Modificar</button></center>
        </form>

        <form action="mis_cvs.php?accion=eliminar1&id=<?php echo $cvData['id_info']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este CV?');" method="POST">
            <center><button type="submit" id="form_button2"><img src="images/borrar.png" height="50" width="50">Eliminar</button></center>
        </form>
      
        <form action="cv_uploads/<?php echo htmlspecialchars($cvData['archivo_pdf']); ?>" method="get" target="_blank" style="display: inline;">
    <center><button type="submit" id="form_button2"><img src="images/pdf.png" height="50" width="50">Ver CV</button></center>
</form>
    </div>
    
               
       <?php endwhile; ?>
        <?php else: ?>
            <p style="display: block; margin: 0 auto;">No se encontraron resultados para la búsqueda.</p>
        <?php endif; ?></div>

<button id="prevButton" class="slider-button"><img src="guardadas/anterior.png" height="20" width="20"></button>
<button id="nextButton" class="slider-button"><img src="guardadas/siguiente.png" height="20" width="20"></button>
</div>
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
<script>
function agregarExperiencia() {
    const experienciaContainer = document.querySelector('fieldset:nth-of-type(2)');
    const nuevaExperiencia = `
        <div class="experiencia-extra">
            <label for="empresa">Empresa:</label>
            <input type="text" name="empresa[]" placeholder="Nombre de la empresa" required>

            <label for="puesto">Puesto:</label>
            <input type="text" name="puesto[]" placeholder="Puesto desempeñado" required>

            <label for="duracion">Duración:</label>
            <input type="text" name="duracion[]" placeholder="Ej: 2019-2022" required>
        </div>
    `;
    experienciaContainer.insertAdjacentHTML('beforeend', nuevaExperiencia);
}

function agregarEducacion() {
    const educacionContainer = document.querySelector('fieldset:nth-of-type(3)');
    const nuevaEducacion = `
        <div class="educacion-extra">
            <label for="institucion">Institución:</label>
            <input type="text" name="institucion[]" placeholder="Nombre de la institución" required>

            <label for="titulo">Título o Grado:</label>
            <input type="text" name="titulo[]" placeholder="Ej: Licenciatura en Sistemas" required>

            <label for="fecha">Fecha de Graduación:</label>
            <input type="date" name="fecha[]" required>
        </div>
    `;
    educacionContainer.insertAdjacentHTML('beforeend', nuevaEducacion);
}

</script>
<script>
let currentIndex = 0;
const cvSlider = document.getElementById('cvSlider');
const totalSlides = document.querySelectorAll('.cv-card').length;

document.getElementById('nextButton').addEventListener('click', () => {
    if (currentIndex < totalSlides - 1) {
        currentIndex++;
        updateSlider();
    }
});

document.getElementById('prevButton').addEventListener('click', () => {
    if (currentIndex > 0) {
        currentIndex--;
        updateSlider();
    }
});

function updateSlider() {
    const offset = -currentIndex * 100; 
    cvSlider.style.transform = `translateX(${offset}%)`;
}

</script>


      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
       <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
   </body>
</html>
