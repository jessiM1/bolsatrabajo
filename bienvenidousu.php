<?php   
session_start();
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
                  
                 <?php
   
    require_once 'conexion.php'; 
    error_reporting(0);

   
    $correo = $_SESSION['correo'];

    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    if (isset($_SESSION['correo'])) {
        $correo = $_SESSION['correo'];
        echo "<div class='titlepage'>
              
                <h2><center>Bienvenido {$correo}</center></h2>
              </div>";
			   $sql = "SELECT * FROM vacantes";
    $result = $conn->query($sql);
			  
			  ?> 
              <section class="vacantes_section layout_padding">
    <div class="container">
    <center><h1>¿Buscas algo en especial?</h1></center>
    <center><p>¡Aquí podrás encontrarlo!</p></center>
     
        <!-- Barra de búsqueda y filtros -->
  <div class="filtros_busqueda">
    <form method="GET" action="" id="filtrosForm">
        <div class="row">
            <div class="col-md-3">
                <input type="text" class="form-control" name="puesto" placeholder="Buscar por puesto" value="<?php echo isset($_GET['puesto']) ? $_GET['puesto'] : ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="habilidades" placeholder="Buscar por habilidades" value="<?php echo isset($_GET['habilidades']) ? $_GET['habilidades'] : ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="ubicacion" placeholder="Buscar por ubicación" value="<?php echo isset($_GET['ubicacion']) ? $_GET['ubicacion'] : ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="salario_min" placeholder="Salario mínimo" value="<?php echo isset($_GET['salario_min']) ? $_GET['salario_min'] : ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="salario_max" placeholder="Salario máximo" value="<?php echo isset($_GET['salario_max']) ? $_GET['salario_max'] : ''; ?>">
            </div>
            <br>
            <div class="col-md-12">
                <button type="submit" class="read_more" style="display: block; margin: 0 auto;">Buscar</button>
            </div>
        </div>
    </form>
</div>

               
        </div>
        

        <?php
        // Recoger los valores de los filtros
        $puesto = isset($_GET['puesto']) ? $_GET['puesto'] : '';
        $habilidades = isset($_GET['habilidades']) ? $_GET['habilidades'] : '';
		$ubicacion = isset($_GET['ubicacion']) ? $_GET['ubicacion'] : '';


        $horario = isset($_GET['horario']) ? $_GET['horario'] : '';
        $salario_min = isset($_GET['salario_min']) ? $_GET['salario_min'] : '';
        $salario_max = isset($_GET['salario_max']) ? $_GET['salario_max'] : '';

        // Construir la consulta base
        $sql = "SELECT v.*, e.direccion_empresa FROM vacantes v
		JOIN empresa e ON v.id_empresa=e.id_e
		  WHERE 1";

        // Definir los parámetros para la consulta
        $params = [];
        if ($puesto != '') {
            $sql .= " AND puesto LIKE ?";
            $params[] = "%" . $puesto . "%";
        }
        if ($habilidades != '') {
            $sql .= " AND habilidades LIKE ?";
            $params[] = "%" . $habilidades . "%";
        }
        if ($horario != '') {
            $sql .= " AND horario = ?";
            $params[] = $horario;
        }
		
		if ($ubicacion != '') {
    $sql .= " AND direccion_empresa LIKE ?";
    $params[] = "%" . $ubicacion . "%";
}

		
        if ($salario_min != '') {
            $sql .= " AND salario >= ?";
            $params[] = $salario_min;
        }
        if ($salario_max != '') {
            $sql .= " AND salario <= ?";
            $params[] = $salario_max;
        }

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Enlazar los parámetros si existen
        if (!empty($params)) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los resultados
        $result = $stmt->get_result();
        ?>

        <!-- Vacantes -->
        <br>
        
           <center> <h1>Vacantes Disponibles</h1></center>
            <center> <p>Encuentra la oportunidad perfecta para ti.</p></center>
       
       <br>
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($vacante = $result->fetch_assoc()): ?>
                    <div class="col-md-6 col-lg-12">
                        <div class="box">
                            <div class="detail-box">
                            <br>
                                <h1><?php echo htmlspecialchars($vacante['puesto']); ?></h1>
                                <p><strong>Descripción:</strong> <?php echo htmlspecialchars($vacante['prestaciones']); ?></p>
                                <button class="read_more" type="button" data-bs-toggle="collapse" data-bs-target="#vacante<?php echo $vacante['id_vacante']; ?>" aria-expanded="false" aria-controls="vacante<?php echo $vacante['id_vacante']; ?>">
                                    Ver más detalles
                                </button>

                                <div class="collapse" id="vacante<?php echo $vacante['id_vacante']; ?>">
                                    <div class="card card-body mt-2">
                                        <p><strong>Salario:</strong> <?php echo htmlspecialchars($vacante['salario']); ?></p>
                                        <p><strong>Horario:</strong> <?php echo htmlspecialchars($vacante['horario']); ?></p>
                                        <p><strong>Habilidades:</strong> <?php echo htmlspecialchars($vacante['habilidades']); ?></p>
                                         <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($vacante['direccion_empresa']); ?></p>

                                        <?php if (isset($_SESSION['correo'])): ?>
                                            <form action="aplicar.php" method="POST">
                                                <input type="hidden" name="id_vacante" value="<?php echo $vacante['id_vacante']; ?>">
                                                <button type="submit" name="aplicar" class="btn-btn-success">Aplicar</button>
                                            </form>
                                            
                                        <?php else: ?>
                                            <p class="text-danger">Debe iniciar sesión para aplicar a esta vacante.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>No hay vacantes disponibles en este momento.</p>
                </div>
            <?php endif; ?>
    </div>

    </div>
</section>  
              

       
              <?php
			  
    }
    
   
    ?>
     
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
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
       <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>



</body>
</html>