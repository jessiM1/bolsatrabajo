<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
error_reporting(E_ALL);
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
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
       <!-- Incluir Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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

/* Eliminar el borde del contenedor cuando se abre */
.collapse.show {
    border: none;  /* Elimina el borde de la tarjeta cuando está expandida */
    box-shadow: none;  /* Elimina la sombra */
}

.card.card-body {
    border: none;  /* Asegúrate de que no tenga borde */
    box-shadow: none;  /* Elimina la sombra predeterminada de la tarjeta */
}

.card-body {
    padding: 15px;  /* Ajusta el padding para darle un espacio más limpio */
}

/* Si deseas agregar un efecto de suavizado en la transición */
.collapse {
    transition: all 0.3s ease;  /* Agrega una transición suave */
}


   </style>
   <!-- body -->
   <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora - Sistema</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="main-layout">
    <!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="Cargando..." /></div>
    </div>
    <!-- end loader -->

    <!-- Sidebar -->
    <div id="mySidepanel" class="sidepanel">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.php">INICIO</a>
        <a href="login.php">LOGIN</a>
    </div>

    <!-- header -->
    <header>
        <div class="head-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="logo">
                            <a href="index.php"><img src="images/bol.png" height="500" width="90" alt="Logo" /></a>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <ul class="email text_align_right">
                            <li>
                                <a href="javascript:void(0);" id="notificaciones-toggle">
                                    <i class="fas fa-bell"></i>
                                </a>
                            </li>
                            <li class="d_none">
                                <a href="logout.php">Cerrar Sesión</a>
                            </li>
                        </ul>
                        <div id="notificaciones-container" style="display:none;">
                            <h2><center>Notificaciones</center></h2>
                            <div id="notificaciones-list">
                                <!-- Notificaciones cargadas dinámicamente -->
                            </div>
                        </div>
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

                        <?php
                        require_once 'conexion.php';

                        if (!isset($_SESSION['correo'])) {
                            echo "<h3>No has iniciado sesión. <a href='login.php'>Inicia sesión aquí</a></h3>";
                            exit;
                        }

                        $correo = $_SESSION['correo'];
                        echo "<h2><center>Bienvenido " . htmlspecialchars($correo) . "</center></h2>";

                        $sql = "SELECT id_b, accion, descripcion, fecha_modificacion, id_usuario, tabla_modificada FROM bitacora";
                        $resultado = $conn->query($sql);
                        ?>

                        <section class="vacantes_section layout_padding">
                            <div class="container">
                                <h1>Registros de la Bitácora</h1>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Acción</th>
                                            <th>Descripción</th>
                                            <th>Fecha de Modificación</th>
                                            <th>ID Usuario</th>
                                            <th>Tabla Modificada</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($resultado->num_rows > 0) {
                                            while ($fila = $resultado->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($fila['id_b']) . "</td>";
                                                echo "<td>" . htmlspecialchars($fila['accion']) . "</td>";
                                                echo "<td>" . htmlspecialchars($fila['descripcion']) . "</td>";
                                                echo "<td>" . htmlspecialchars($fila['fecha_modificacion']) . "</td>";
                                                echo "<td>" . htmlspecialchars($fila['id_usuario']) . "</td>";
                                                echo "<td>" . htmlspecialchars($fila['tabla_modificada']) . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>No hay registros en la bitácora</td></tr>";
                                        }

                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer>
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <ul class="social_icon text_align_center"></ul>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="reader">
                            <a href="index.php"><img src="images/bol.png" height="250" width="250" alt="Logo" /></a>
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
                </div>
            </div>
            <div class="copyright text_align_center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <p>Copyright 2024 By <a href="https://html.design/">Bol UMB</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Javascript files -->
    <script>
        document.getElementById('notificaciones-toggle').addEventListener('click', function () {
            const container = document.getElementById('notificaciones-container');
            container.style.display = (container.style.display === 'none' || container.style.display === '') ? 'block' : 'none';
        });

        async function cargarNotificaciones() {
            try {
                const response = await fetch('phpobtenernotificaciones.php');
                const data = await response.json();
                const notificacionesList = document.getElementById('notificaciones-list');
                notificacionesList.innerHTML = '';

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
                document.getElementById('notificaciones-list').innerHTML = '<h6>Error al cargar las notificaciones.</h6>';
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
                    cargarNotificaciones();
                } else {
                    console.error('Error al marcar como leída:', data.error);
                }
            } catch (error) {
                console.error('Error al enviar la solicitud:', error);
            }
        }

        document.addEventListener('DOMContentLoaded', cargarNotificaciones);
        setTimeout(function actualizarNotificaciones() {
            cargarNotificaciones();
            setTimeout(actualizarNotificaciones, 30000);
        }, 


</script>
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
       <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>



</body>
</html>