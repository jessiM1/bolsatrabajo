<?php 

include 'conexion.php';

// Verificar que la empresa haya iniciado sesión
session_start();
if (!isset($_SESSION['empresa_id'])) {
    header("Location: inicioempresa.php");
    exit();
}

$correo = $_SESSION['correo'];
$empresa_id = $_SESSION['empresa_id'];

// Obtener información del buscador
$sql = "SELECT nombre_empresa,rfc_empresa,direccion_empresa, telefono_empresa, descripcion_empresa, correo, nombre_reclutador,apaterno_reclutador,descripcion_empresa,amaterno_reclutador, imagen, foto_portada FROM empresa WHERE id_e = '$empresa_id'";
$resultado = mysqli_query($conn, $sql);
$buscador = mysqli_fetch_assoc($resultado);

// Proesar la actualización de datos personales
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_datos'])) {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
	$rfc= mysqli_real_escape_string($conn, $_POST['rfc']);
	$dir = mysqli_real_escape_string($conn, $_POST['dir']);
	$tel = mysqli_real_escape_string($conn, $_POST['tel']);
	$descripcion_empresa = mysqli_real_escape_string($conn, $_POST['descripcion_empresa']);
    $correo_actualizado = mysqli_real_escape_string($conn, $_POST['correo']);
    $reclutador = mysqli_real_escape_string($conn, $_POST['reclutador']);
    $apreclutador = mysqli_real_escape_string($conn, $_POST['apreclutador']);
    $amreclutador = mysqli_real_escape_string($conn, $_POST['amreclutador']);


    $sql_update = "UPDATE empresa SET 
        nombre_empresa = '$nombre', 
        rfc_empresa = '$rfc', 
        direccion_empresa = '$dir', 
        telefono_empresa = '$tel', 
        descripcion_empresa = '$descripcion_empresa',
        correo = '$correo_actualizado', 
        telefono_empresa = '$tel',
		nombre_reclutador='$reclutador',
		apaterno_reclutador='$apreclutador',
		amaterno_reclutador='$amreclutador'		
        WHERE id_e = '$empresa_id'";

               
        

    if (mysqli_query($conn, $sql_update)) {
        $mensaje = "Datos actualizados exitosamente.";
        // Refrescar los datos después de actualizar
        $sql = "SELECT nombre_empresa,rfc_empresa,direccion_empresa, telefono_empresa, descripcion_empresa, correo, nombre_reclutador,apaterno_reclutador,amaterno_reclutador,descripcion_empresa, imagen, foto_portada FROM empresa WHERE id_e = '$empresa_id'";
        $resultado = mysqli_query($conn, $sql);
        $buscador = mysqli_fetch_assoc($resultado);
    } else {
        $mensaje = "Error al actualizar los datos: " . mysqli_error($conn);
    }
}

// Procesar la actualización de fotos de perfil
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_perfil'])) {
    // Manejar la carga de la foto de perfil
    if (isset($_FILES['profile-upload']) && $_FILES['profile-upload']['error'] == 0) {
        $target_dir = "uploads/";
        $profile_file_name = $id_buscador . "_perfil_" . basename($_FILES["profile-upload"]["name"]);
        $profile_target_file = $target_dir . $profile_file_name;

        if (move_uploaded_file($_FILES["profile-upload"]["tmp_name"], $profile_target_file)) {
            $foto_perfil = $profile_target_file;
            // Actualizar la foto de perfil en la base de datos
            $sql_update_perfil = "UPDATE empresa SET imagen = '$foto_perfil' WHERE id_e = '$empresa_id'";
            mysqli_query($conn, $sql_update_perfil);
        }
    }
    // Refrescar las fotos después de actualizarlas
    $sql = "SELECT nombre_empresa,rfc_empresa,direccion_empresa, telefono_empresa, descripcion_empresa, correo, nombre_reclutador,apaterno_reclutador,amaterno_reclutador, imagen, foto_portada FROM empresa WHERE id_e ='$empresa_id'";
    $resultado = mysqli_query($conn, $sql);
    $buscador = mysqli_fetch_assoc($resultado);
}

// Procesar la actualización de fotos de portada
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_portada'])) {
    // Manejar la carga de la foto de portada
    if (isset($_FILES['cover-upload']) && $_FILES['cover-upload']['error'] == 0) {
        $target_dir = "uploads/";
        $cover_file_name = $id_buscador . "_portada_" . basename($_FILES["cover-upload"]["name"]);
        $cover_target_file = $target_dir . $cover_file_name;

        if (move_uploaded_file($_FILES["cover-upload"]["tmp_name"], $cover_target_file)) {
            $foto_portada = $cover_target_file;
            // Actualizar la foto de portada en la base de datos
            $sql_update_portada = "UPDATE empresa SET foto_portada = '$foto_portada' WHERE id_e = '$empresa_id'";
            mysqli_query($conn, $sql_update_portada);
        }
    }
    // Refrescar las fotos después de actualizarlas
    $sql = "SELECT nombre_empresa,rfc_empresa,direccion_empresa, telefono_empresa, descripcion_empresa, correo, nombre_reclutador, apaterno_reclutador,amaterno_reclutador,descripcion_empresa, imagen, foto_portada FROM empresa WHERE id_e ='$empresa_id'";
    $resultado = mysqli_query($conn, $sql);
    $buscador = mysqli_fetch_assoc($resultado);
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


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


.parent-container {
    display: flex;
    justify-content: center; /* Centra horizontalmente */
    align-items: center;    /* Centra verticalmente (opcional) */
	
   
}
.cv-form {
 border: solid 3px #474544;
    min-width:90%; 
    max-width: 90%; 
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
   margin-top: -170px;
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

input[type='text'], [type='email'], [type='tel'],  [type='number'], [type='date'],[type='file'], select, textarea {
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

input[type='text']:focus, [type='email']:focus, [type='file']:focus, [type='date']:focus, [type='number']:focus,textarea:focus {
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


.card-img-top {
    height: 300px;
    object-fit: cover;
}

.card-no-border .card {
    border-color: #d7dfe3;
    border-radius: 4px;
    -webkit-box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
    box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
}

.card-body {
    padding: 1.25rem;
    margin-top: -100px; /* Ajusta el margen superior para subir el contenido */
}

.pro-img {
    margin-top: -100px; /* Subir la imagen de perfil más arriba */
    margin-bottom: 0px; /* Reducir espacio debajo de la imagen */
}

.little-profile .pro-img img {
    width: 128px;
    height: 128px;
    object-fit: cover;
    border-radius: 100%;
    margin-top: -48px; /* Subir más la imagen de perfil */
}

h3 {
    line-height: 30px;
    font-size: 21px;
    margin-top: -200px; /* Ajusta este valor para subir el texto más arriba */
}


.btn-rounded {
    border-radius: 60px;
    padding: 7px 18px;
}

.m-t-20 {
    margin-top: 20px;
}

.text-center {
    text-align: center !important;
}

input[type="file"] {
    display: none;
}

.upload-label {
    cursor: pointer;
    background-color: #7460ee;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    display: inline-block;
    margin: 5px;
}

/* Subir labels e inputs más usando posicionamiento absoluto */
form label,
form input,  
form button{
    position: relative;
    top: -85px; /* Ajusta el valor según lo que necesites */
}

.btn {
  font-size: 12px;
  font-size: 0.75rem;
  text-decoration: none;
  text-transform: uppercase;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  color: #8b1310;
 
 
 
  text-shadow: 0 1px 0px #780d33;
}

.btn-action {
  font-weight: bold;
  background: transparent!important;
 
  text-shadow: none;
}
.btn-action:hover,
.btn-action:focus,
.btn-action:active,
.btn-action.active {
  color: #fd990c;
 
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
                      
                          <li class="d_none"> <a href="bienvenidoempresa.php">INICIO</a></li>
                       <li class="d_none"> <a href="vacantepos.php">VACANTES PUBLICADAS</a></li>
                        <li class="d_none"> <a href="publicarvacante.php">PUBLICAR VACANTE</a></li>
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
               <div class="col-md-12">
                  <div class="titlepage">
                  <div class="card">
               
 <?php 
$foto_portada = $buscador['foto_portada'] ? $buscador['foto_portada'] : 'http://localhost/Avo/ESCUELA/basco-html/images/trabajo.avif';
?>
<img src="<?php echo $foto_portada; ?>" alt="Foto de Portada" class="card-img-top" class="pro-img" width="300">

<!-- Formulario para actualizar foto de portada -->
<form action="" method="post" enctype="multipart/form-data">
   
    <label for="cover-upload"><img src="images/editar.png" height="25" width="25"></label>
    <input type="file" id="cover-upload" name="cover-upload" accept="image/*">
    <button type="submit" name="actualizar_portada" class="btn btn-action"  >Actualizar Foto de Portada</button>
</form>

  
<!-- Mostrar foto de perfil actual -->
<div class="card-body little-profile text-center">

<?php 
$foto_perfil = $buscador['imagen'] ? $buscador['imagen'] : 'http://localhost/Avo/ESCUELA/basco-html/images/perfil.png';
?>
<div class="pro-img">
<img src="<?php echo $foto_perfil; ?>" alt="Foto de Perfil"  width="150">
</div>
<!-- Formulario para actualizar foto de perfil -->
<form action="" method="post" enctype="multipart/form-data">
   
    <label for="profile-upload"><img src="images/editar.png" height="25" width="25"></label>
    <input type="file" id="profile-upload" name="profile-upload"accept="image/*">
    <button type="submit" name="actualizar_perfil" class="btn btn-action"  >Actualizar foto de perfil</button>
</form>

<!-- Mostrar foto de portada actual -->




                    <h2><?= htmlspecialchars($buscador['nombre_empresa']); ?> </h2>
                  
                 <br>  
        <p>RFC de la empresa: <?= htmlspecialchars($buscador['rfc_empresa']); ?></p>
        <br>
        <p>Dirección de la empresa: <?= htmlspecialchars($buscador['direccion_empresa']); ?></p>
        <br>
        <p>Telefono: <?= htmlspecialchars($buscador['telefono_empresa']); ?></p>
        <br>
        <p>Descripción de la empresa: <?= htmlspecialchars($buscador['descripcion_empresa']); ?></p>
        <br>
        <p>Correo: <?= htmlspecialchars($buscador['correo']); ?></p>
        <br>
        <p>Nombre del reclutador: <?= htmlspecialchars($buscador['nombre_reclutador']); ?></p>
        <br>
        <p>Apellido paterno del reclutador: <?= htmlspecialchars($buscador['apaterno_reclutador']); ?></p>
         <p>Apellido materno del reclutador: <?= htmlspecialchars($buscador['amaterno_reclutador']); ?></p>
        
         <!-- Botón para abrir el modal -->
         <br>
        <button type="button"  data-bs-toggle="modal" data-bs-target="#editModal">
           <img src="images/editar.png" height="25" width="25">
        </button>
  
                   </div>
                
          
    <!-- Modal para editar los datos -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
               <div class="parent-container">
                
                  <div class="cv-form">
                   
                 
             
                <div class="modal-body">
               
                    <form method="POST" action="">

                       <div>
                            <label for="nombre" >Nombre de la empresa</label>
                            <input type="text"  name="nombre" value="<?= htmlspecialchars($buscador['nombre_empresa']); ?>" required>
                      </div>
                       <div>
                            <label for="rfc">RFC de la empresa</label>
                            <input type="text"  name="rfc" value="<?= htmlspecialchars($buscador['rfc_empresa']); ?>" required>
                         </div>
                          <div>
                       
                            <label for="dir" >Dirección de la empresa</label>
                            <input type="text"  name="dir" value="<?= htmlspecialchars($buscador['direccion_empresa']); ?>" required>
                        </div>
                         <div>                       
                            <label for="tel">Teléfono</label>
                            <input type="text"  name="tel" value="<?= htmlspecialchars($buscador['telefono_empresa']); ?>" required>
                         </div>   
                          <div>
                            <label for="descripcion_empresa">Descripción de la empresa</label>
                       <input name="descripcion_empresa"  value="<?= htmlspecialchars($buscador['descripcion_empresa']); ?>" required class="form-control">
                  </div>
        
                         <div>
                            <label for="correo" >Correo</label>
                            <input type="email"  name="correo" value="<?= htmlspecialchars($buscador['correo']); ?>" required>
                        </div>
                         <div>
                            <label for="reclutador">Nombre del reclutador</label>
                            <input type="text"  name="reclutador" value="<?= htmlspecialchars($buscador['nombre_reclutador']); ?>" required>
                        </div>
                        <div>
                        
                  <label for="apreclutador">Apellido paterno del reclutador </label><input type="text"  name="apreclutador" value="<?= htmlspecialchars($buscador['apaterno_reclutador']); ?>" required>
                  </div>
                  <div>
               <label for="amreclutador">Apellido materno del reclutador </label><input type="text"  name="amreclutador" value="<?= htmlspecialchars($buscador['amaterno_reclutador']); ?>" required>
              </div>
                  

                        <button type="submit" class="read_more" name="actualizar_datos" style="display: block; margin: 0 auto;">Actualizar Datos</button>
                    </form>
              
            </div>
        </div>
   </div>
        </div>
   </div>
       </div>
        </div>
  
  
  

    <?php if (!empty($mensaje)) { echo "<script>alert('$mensaje');</script>"; } ?>

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
        const response = await fetch('phpobtenernotificacionesempresa.php');
        const data = await response.json();
        const notificacionesList = document.getElementById('notificaciones-list');
        notificacionesList.innerHTML = ''; // Limpiar notificaciones anteriores

        if (data.length > 0) {
            data.forEach(notificacion => {
                const div = document.createElement('div');
                div.classList.add
				('notificacion');
                div.innerHTML = `
                    <h6>${notificacion.mensaje} para el puesto de ${notificacion.puesto}</h6>
					
                    <small>${new Date(notificacion.fecha).toLocaleString('es-ES', { dateStyle: 'short', timeStyle: 'short' })}</small>
                    <button class="marcar-leida-btn" data-id="${notificacion.id_ne}" style="display: block; margin: 0 auto;">
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
        const response = await fetch('phpmarcarleidaempresa.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id_ne: idNotificacion })
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