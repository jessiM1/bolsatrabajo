<?php    
session_start();
include 'conexion.php';

$mensaje = ''; // Variable para el mensaje de éxito o error

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['aplicar'])) {
    $id_vacante = $_POST['id_vacante'];
} else {
    $mensaje = 'Faltan datos necesarios para completar la operación.';
}

// Obtener lista de CVs del usuario logueado
$cvs = [];


if (isset($_SESSION['correo'])) {
    $correo = $_SESSION['correo'];
	
	$queryID = "SELECT * FROM buscadores WHERE correo = '$correo'";
    $resultID = mysqli_query($conn, $queryID);
    if ($resultID) {
        while ($row = mysqli_fetch_assoc($resultID)) {
            $id_buscador =$row['id_buscador'];
        }
    }
	
	
	
	
    $query = "SELECT * FROM cv WHERE id_info IN (SELECT id_info FROM informacion_personal WHERE id_buscador= '$id_buscador')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $cvs[] = $row;
        }
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
form input[type="text"], 
form input[type="number"] {
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

form input[type="text"]:focus,
form input[type="number"]:focus {
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

#notificaciones-container {
    width: 300px;
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    padding: 10px;
    position: absolute;
    top: 50px; 
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
.btn-btn-success{
	 display: block;
     background:#fd990c;
     color: #fff;
     max-width: 150px;
     height: 61px;
     padding: 14px 0px;
     width: 100%;
     font-size: 17px;
     text-align: center;
     font-weight: 500;
     transition: ease-in all 0.5s;
	}
	/* Import Google font - Poppins */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');


.wrapper {
  width: 430px;
  background: #fff;
  border-radius: 5px;
  padding: 30px;
  box-shadow: 7px 7px 12px rgba(0,0,0,0.05);
}

.form-group {
  display: flex;
  flex-direction: column;
  margin: 10px 0;
}

.form-group label {
  font-size: 16px;
  margin-bottom: 10px;
  color: #333;
}

.form-group form {
  height: 167px;
  display: flex;
  cursor: pointer;
  margin: 30px 0;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  border-radius: 5px;
  border: 2px dashed #6990F2;
}

form i {
  font-size: 50px;
  color: #6990F2;
}

form p {
  margin-top: 15px;
  font-size: 16px;
  color: #6990F2;
}

section .row {
  margin-bottom: 10px;
  background: #E9F0FF;
  list-style: none;
  padding: 15px 20px;
  border-radius: 5px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

section .row i {
  color: #6990F2;
  font-size: 30px;
}

section .details span {
  font-size: 14px;
}

.progress-area .row .content {
  width: 100%;
  margin-left: 15px;
}

.progress-area .details {
  display: flex;
  align-items: center;
  margin-bottom: 7px;
  justify-content: space-between;
}

.progress-area .content .progress-bar {
  height: 6px;
  width: 100%;
  margin-bottom: 4px;
  background: #fff;
  border-radius: 30px;
}

.content .progress-bar .progress {
  height: 100%;
  width: 0%;
  background: #6990F2;
  border-radius: inherit;
}

.uploaded-area {
  max-height: 232px;
  overflow-y: scroll;
}

.uploaded-area .row .content {
  display: flex;
  align-items: center;
}

.uploaded-area .row .details {
  display: flex;
  margin-left: 15px;
  flex-direction: column;
}

.uploaded-area .row .details .size {
  color: #404040;
  font-size: 11px;
}

.uploaded-area i.fa-check {
  font-size: 16px;
}



.center-wrapper { 
  display: flex;
  justify-content: center; /* Centra el contenedor horizontalmente */
  align-items: flex-start; /* Alinea los elementos al principio, no al centro */
  height: 100vh; /* Mantiene la altura completa de la pantalla */
  margin: 0; 
}

.upload-container {
  background: #ffffff;
  padding: 20px 40px 40px; /* Ajusta el padding superior para reducir el espacio */
 
  box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
  text-align: center;
  width: 360px;
}


.upload-container h1 {
  font-size: 22px;
  font-weight: bold;
  color: #333;
  margin-bottom: 8px;
}

.upload-container p {
  font-size: 14px;
  color: #777;
  margin-bottom: 30px;
}

    /* Drag and Drop Box */
    .upload-box {
      border: 2px dashed #fd990c;
      background-color: #fff0ed;
      border-radius: 12px;
      padding: 40px;
      position: relative;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      align-items: center; /* Centers the folder icon horizontally */
      justify-content: center; /* Centers the folder icon vertically */
      height: 200px; /* Set a fixed height for the drag-and-drop box */
    }

    .upload-box:hover {
      background-color: #ffdad1 ;
    }

    .upload-box img {
      width: 60px;
      margin-bottom: 10px;
    }

    .upload-box span {
      font-size: 14px;
      color: #888;
    }

    /* File Name Display */
    .file-name {
      font-size: 14px;
      color: #555;
      margin-top: 10px;
      display: none; 
    }

    /* Hidden File Input */
    #cv_nuevo {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
    }
.marcar-leida-btn {
  display: block;
  margin: -250px auto 0;  /* Ajusta el margen superior para acercar el botón */
  background: #8b1310;
  color: #fff;
    max-width: 224px;
     height: 61px;
  padding: 14px 0px;
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
                         <li class="d_none"> <a href="cv.php">Crear CV <i  aria-hidden="true"></i></a> </li>
                          <li class="d_none"> <a href="mis_cvs.php">Ver mis CV <i  aria-hidden="true"></i></a> </li>
                         <li class="d_none"> <a href="miperfil.php">Mi Perfil<i  aria-hidden="true"></i></a> </li>
                         <li class="d_none"> 
    <a href="javascript:void(0);" id="notificaciones-toggle"> <i class="fas fa-bell"></i></a>
</li>
 <li class="d_none"> <a href="bienvenidoempresa.php">CERRAR SESIÓN</a></li>
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
                      <center><h2>Aplicar a Vacante</h2></center>
                      <br>

        <?php if ($mensaje != ''): ?>
            <script>
                alert("<?php echo $mensaje; ?>");
            </script>
        <?php endif; ?>

       <form action="phpaplicar.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_vacante" value="<?php echo htmlspecialchars($id_vacante); ?>">
    <input type="hidden" name="id_buscador" value="<?php echo htmlspecialchars($id_buscador); ?>">

     <!-- CVs guardados -->
   <!-- Mostrar CVs guardados -->
<div class="row">
    <?php if (empty($cvs)): ?>
        <!-- Mostrar mensaje si no hay CVs guardados -->
        <div class="col-12 text-center">
            <h1>Aún no ha creado CV en el sistema.</h1>
            <br>
            <a href="cv.php" class="read_more" style="display: block; margin: 0 auto;">Crear CV</a>
        </div>
        <br>
    <?php else: ?>
        <!-- Mostrar CVs si existen -->
       <?php foreach ($cvs as $cv): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <embed src="<?php echo htmlspecialchars($cv['archivo_pdf']); ?>" 
                               type="application/pdf" 
                               width="100%" 
                               height="200px">
                        <h5 class="card-title mt-3"><?php echo htmlspecialchars($cv['archivo_pdf']); ?></h5>
                        <button type="button" 
                                class="read_more btn-select-cv" style="display: block; margin: 0 auto;" 
                                data-id="<?php echo htmlspecialchars($cv['id_cv']); ?>">
                            Seleccionar
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<br>
    <!-- Subir un nuevo CV -->
    <div class="center-wrapper">
    <div class="upload-container">
    <h1>O sube un nuevo CV</h1>
    <p>Recuerda que debe ser formato PDF</p>
    <div class="upload-box">
       <img src="https://img.icons8.com/ios-filled/100/fd990c/folder-invoices.png" alt="Folder Icon">
      <span>Sube tus archivos aquí</span>
      <input type="file" name="cv_nuevo" id="cv_nuevo">
       <div class="file-name " id="file-name">Ningún archivo seleccionado</div>
    </div>
  </div>
  </div>
    <!-- Input oculto para el ID del CV seleccionado -->
    <input type="hidden" name="cv_guardado" id="cv_guardado">
   <button type="submit" class="marcar-leida-btn" name="aplicar" style="display: block; ">Aplicar</button>
</form>




       
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
    // Manejo del botón Seleccionar
    document.querySelectorAll('.btn-select-cv').forEach(button => {
        button.addEventListener('click', function () {
            const selectedId = this.getAttribute('data-id');
            document.getElementById('cv_guardado').value = selectedId;
            alert('CV seleccionado correctamente.');
        });
    });
</script>
<script>
    const fileInput = document.getElementById('cv_nuevo');
    const fileNameDisplay = document.getElementById('file-name');

    fileInput.addEventListener('change', function () {
      if (fileInput.files.length > 0) {
        fileNameDisplay.textContent = fileInput.files[0].name; 
        fileNameDisplay.style.display = 'block'; 
      } else {
        fileNameDisplay.textContent = 'Ningún archivo seleccionado';
        fileNameDisplay.style.display = 'none';
      }
    });
  </script>

      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
       <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
   </body>
</html>
