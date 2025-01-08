<?php
// Conexión a la base de datos
require_once 'conexion.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}



function generarFormularioEstatus($postulante, $id_vacante, $conn) {
    $consultaEstatus = "SELECT * FROM estatus_postulacion";
    $resultadoEstatus = $conn->query($consultaEstatus);

    $formulario = '<form method="POST" action="">';
    $formulario .= '<input type="hidden" name="id_postulante" value="' . $postulante['id_buscador'] . '">';
    $formulario .= '<input type="hidden" name="id_vacante" value="' . $id_vacante . '">';
    $formulario .= '<select name="nuevo_estatus" class="form-control">';
    while ($estatus = $resultadoEstatus->fetch_assoc()) {
        $selected = $postulante['estatus'] == $estatus['id_estatus'] ? 'selected' : '';
        $formulario .= '<option value="' . $estatus['id_estatus'] . '" ' . $selected . '>';
        $formulario .= htmlspecialchars($estatus['descripcion']);
        $formulario .= '</option>';
    }
    $formulario .= '</select>';
    $formulario .= '<button type="submit" class="read_more" name="actualizar_estatus">Actualizar</button>';
    $formulario .= '</form>';

    return $formulario;

}

// Obtener el id_vacante desde la URL
$id_vacante = isset($_GET['id_vacante']) ? intval($_GET['id_vacante']) : 0;

// Consultar el puesto de la vacante seleccionada
// Obtener el puesto de la vacante
    $queryPuesto = "SELECT puesto FROM vacantes WHERE id_vacante = ?";
    $stmtPuesto = $conn->prepare($queryPuesto);
    $stmtPuesto->bind_param("i", $id_vacante);
    $stmtPuesto->execute();
    $resultadoPuesto = $stmtPuesto->get_result();
    $puesto = $resultadoPuesto->fetch_assoc();




// Consultar los postulantes para la vacante seleccionada
$consultaPostulantes = "SELECT postulaciones.*, 
               buscadores.nombre, 
               buscadores.apaterno, 
               buscadores.amaterno,
               buscadores.correo, ep.descripcion
        FROM postulaciones
        INNER JOIN buscadores ON postulaciones.id_buscador = buscadores.id_buscador 
        JOIN estatus_postulacion ep ON postulaciones.estatus = ep.id_estatus
        WHERE postulaciones.id_vacante = ? AND postulaciones.estatus != 7";
$stmtPostulantes = $conn->prepare($consultaPostulantes);
$stmtPostulantes->bind_param("i", $id_vacante);
$stmtPostulantes->execute();
$resultadoPostulantes = $stmtPostulantes->get_result();

if (isset($_POST['actualizar_estatus'])) {
    $id_postulante = intval($_POST['id_postulante']);
    $id_vacante = intval($_POST['id_vacante']);
    $nuevo_estatus = intval($_POST['nuevo_estatus']);

    if ($id_postulante > 0 && $id_vacante > 0 && $nuevo_estatus > 0) {
        $sql = "UPDATE postulaciones SET estatus = ? WHERE id_buscador = ? AND id_vacante = ?";
        $stmt = $conn->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            echo "Error al preparar la consulta: " . $conn->error;
            exit();
        }

        $stmt->bind_param("iii", $nuevo_estatus, $id_postulante, $id_vacante);

        if ($stmt->execute()) {
            // Obtener descripción del nuevo estatus
            $queryEstatus = "SELECT descripcion FROM estatus_postulacion WHERE id_estatus = ?";
            $stmtEstatus = $conn->prepare($queryEstatus);
            $stmtEstatus->bind_param("i", $nuevo_estatus);
            $stmtEstatus->execute();
            $resultadoEstatus = $stmtEstatus->get_result();
            $estatus = $resultadoEstatus->fetch_assoc();

            // Insertar notificación para el buscador
            $mensaje = "Tu estatus de la vacante ". $puesto['puesto'].' '."ha cambiado a: " . $estatus['descripcion'];
            $sqlNotificacion = "INSERT INTO notificaciones (id_buscador, id_vacante, mensaje) VALUES (?, ?, ?)";
            $stmtNotificacion = $conn->prepare($sqlNotificacion);
            $stmtNotificacion->bind_param("iis", $id_postulante, $id_vacante, $mensaje);
            $stmtNotificacion->execute();

            header("Location: postulantes.php?id_vacante=" . $id_vacante);
            exit();
        } else {
            echo "Error al actualizar el estatus: " . $conn->error;
        }

        // Asegúrate de cerrar la sentencia solo si se preparó correctamente
        if (isset($stmt)) {
            $stmt->close();
        }
    } else {
        echo "Datos inválidos para actualizar el estatus.";
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
	/* Estilo para el select */
form .form-control {
    width: 100%;
    padding: 10px;
    border: 2px solid #fd990c; /* Borde verde */
    border-radius: 5px; /* Bordes redondeados */
    font-size: 14px; /* Tamaño de letra */
    color: #333; /* Texto gris oscuro */
    background-color: #f9f9f9; /* Fondo claro */
    transition: border-color 0.3s, box-shadow 0.3s; /* Transición */
}

/* Efecto hover para el select */
form .form-control:hover {
    border-color: #fd990c; /* Cambiar el color del borde al pasar el mouse */
    box-shadow: 0 0 5px rgba(56, 142, 60, 0.5); /* Sombra */
}



  .services_main {
    padding: 20px 0;
    background-color: #f7f9fc; /* Fondo claro para la sección */
  }

  .titlepage h2 {
    text-align: center;
    font-family: 'Roboto', sans-serif;
    color: #333;
    margin-bottom: 20px;
  }

  .table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    background-color: white;
  }

  .table thead th {
    background-color: #8b1310; /* Azul oscuro */
    color: white;
    text-align: center;
    padding: 15px;
    font-size: 16px;
  }

  .table tbody tr:nth-child(even) {
    background-color: #f9f9f9; /* Filas alternas */
  }

  .table tbody tr:hover {
    background-color: #ebd3d3 ; /* Color de hover */
  }

  .table td {
    padding: 12px;
    text-align: center;
    font-size: 14px;
    border-bottom: 1px solid #ddd;
  }

  .table iframe {
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  }

  /* Botones dentro de las acciones */
  
  /* Asegurando diseño responsive */
  @media screen and (max-width: 768px) {
    .table iframe {
      width: 100%;
      height: auto;
    }
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
                        <li class="d_none"> <a href="publicarvacante.php">PUBLICAR VACANTE</a></li>
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
       <div class="col-md-offset-3 col-md-12">
        <div class="titlepage">
          
       <h2>Postulantes para la Vacante de <?php echo  $puesto['puesto']; ?></h2>
           </div>
          <table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>CV</th>
            <th>Estatus</th>
            <th>Fecha de Postulación</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($postulante = $resultadoPostulantes->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($postulante['nombre'] . " " . $postulante['apaterno'] . " " . $postulante['amaterno']) ?></td>
                <td><?= htmlspecialchars($postulante['correo']) ?></td>
               
                <td>
                    <?php 
                    // Verificar si el CV existe y mostrarlo en un iframe
                    if (!empty($postulante['cv'])):
                        $cv_path = $postulante['cv']; 
                    ?>
                        <iframe src="cv_uploads/<?= $cv_path ?>" width="600" height="400"></iframe>
                    <?php else: ?>
                        No disponible
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($postulante['descripcion']) ?></td>
                <td><?= htmlspecialchars($postulante['fecha_postulacion']) ?></td>
               <td><?= generarFormularioEstatus($postulante, $id_vacante, $conn) ?></td>

            </tr>
        <?php endwhile; ?>
    </tbody>
</table>


         
        </div>
    </div>

      <!-- end services -->
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
      <!-- empieza notificaciones-->
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
<!-- terminan notificaciones-->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
       <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
   </body>
</html>
