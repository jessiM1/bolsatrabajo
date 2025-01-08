<?php
include 'conexion.php';
session_start(); // Inicia la sesión


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['empresa_id'])) {
        $empresa_id = $_SESSION['empresa_id'];  
        $puesto = $_POST['puesto'];
        $salario = $_POST['salario'];
        $horario = $_POST['horario'];
        $habilidades = $_POST['habilidades'];
        $prestaciones = $_POST['prestaciones'];
        $experiencia = $_POST['experiencia'];
        $tiempo_experiencia = $_POST['tiempo_experiencia'];
        $formacion = $_POST['formacion'];
        $idioma = $_POST['idioma'];
        $rol = $_POST['rol'];

        $sql = "INSERT INTO vacantes (id_empresa, puesto, salario, horario, habilidades, prestaciones, experiencia, tiempo_experiencia, formacion, idioma, rol) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssss", $empresa_id, $puesto, $salario, $horario, $habilidades, $prestaciones, $experiencia, $tiempo_experiencia, $formacion, $idioma, $rol);

        if ($stmt->execute()) {
            echo "Vacante publicada exitosamente.";
        } else {
            echo "Error al registrar la vacante: " . $stmt->error;
        }
    } else {
        echo "Error: No se encontró la sesión activa.";
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

input[type='text'], [type='email'], [type='tel'],  [type='number'], select, textarea {
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

input[type='text']:focus, [type='email']:focus, [type='number']:focus, textarea:focus {
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
  background: none;
  border: solid 2px #474544;
  color: #474544;
  cursor: pointer;
  display: inline-block;
  font-family: 'Helvetica', Arial, sans-serif;
  font-size: 0.875em;
  font-weight: bold;
  outline: none;
  padding: 20px 35px;
  text-transform: uppercase;
  -webkit-transition: all 0.3s;
  -moz-transition: all 0.3s;
  -ms-transition: all 0.3s;
  -o-transition: all 0.3s;
  transition: all 0.3s;
}

#form_button:hover {
  background: #474544;
  color: #F2F3EB;
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




/* CSS Document */

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
                        <li class="d_none"> <a href="miperfilempresa.php">MI PERFIL</a></li>
                        <li class="d_none"> 
    <a href="javascript:void(0);" id="notificaciones-toggle"> <i class="fas fa-bell"></i></a>
</li>
<li class="d_none"> <a href="logout.php">CERRAR SESIÓN</a></li>
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
                  <h2>Publicar Vacante</h2>
                  <br>
                  <div class="parent-container">
                   
                  <div class="cv-form">

                             <form action="" method="POST"  class="form-horizontal" id="vacanteForm">
                            <input type="text" name="puesto" id="puesto" placeholder="Puesto" required >
                              
                            
                              
                            <input type="number" name="salario" id="salario" placeholder="Salario" required >
                              
                            <input type="text" name="horario" id="horario" placeholder="Horario de trabajo" required >
                              
                            
                              
                           <textarea name="habilidades" id="habilidades" placeholder="Habilidades requeridas" required ></textarea>
                               
                            
                              
                           <textarea name="prestaciones" id="prestaciones" placeholder="Prestaciones ofrecidas" required ></textarea>

                               
                            
                              
                            <input type="text" name="experiencia" id="experiencia" placeholder="Experiencia requerida" required >

                              
                            
                               
                           <input type="text" name="tiempo_experiencia" id="tiempo_experiencia" placeholder="Tiempo de experiencia" required >

                              
                              
                            <textarea name="formacion" id="formacion" placeholder="Formación académica requerida" required ></textarea>

                           <input type="text" name="idioma" id="idioma" placeholder="Idioma(s) requeridos" required >

                              
                            <input type="text" name="rol" id="rol" placeholder="Rol del puesto" required >

                                
                              <button type="submit" class="read_more" style="display: block; margin: 0 auto;">Publicar Vacante</button>


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

      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
       <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
   </body>
</html>
<?php
$stmt->close();
$conexion->close();
?>
