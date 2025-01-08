<?php
session_start();
include 'conexion.php';

// Consulta para obtener las vacantes
$sql = "SELECT v.*, e.direccion_empresa FROM vacantes v JOIN empresa e ON v.id_empresa = e.id_e WHERE 1";

// Preparar filtros de búsqueda
$params = [];
if (!empty($_GET['puesto'])) {
    $sql .= " AND puesto LIKE ?";
    $params[] = "%" . $_GET['puesto'] . "%";
}
if (!empty($_GET['habilidades'])) {
    $sql .= " AND habilidades LIKE ?";
    $params[] = "%" . $_GET['habilidades'] . "%";
}
if (!empty($_GET['ubicacion'])) {
    $sql .= " AND direccion_empresa LIKE ?";
    $params[] = "%" . $_GET['ubicacion'] . "%";
}
if (!empty($_GET['salario_min'])) {
    $sql .= " AND salario >= ?";
    $params[] = $_GET['salario_min'];
}
if (!empty($_GET['salario_max'])) {
    $sql .= " AND salario <= ?";
    $params[] = $_GET['salario_max'];
}

// Preparar la consulta
$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$usuarioLogueado = isset($_SESSION['correo']);
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
    font-size: 16px;
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
.form-container {
  max-width: 600px;
  margin: 0 auto;
}

.form-group {
  display: grid;
  grid-template-columns: 1fr 1fr; 
  gap: 20px; 
}
.services_main .row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; 
    gap: 20px; 
}

.services_img {
    display: flex;
    justify-content: center;
    align-items: center;
}

.circle-img {
    width: 200px;
    height: 200px; 
    border-radius: 50%; 
    object-fit: cover; 
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
    transition: all 0.3s ease; 
    margin: 10px auto;
    display: block;
}

.circle-img:hover {
    transform: scale(1.1);  /* Aumenta el tamaño de la imagen */
    /* Sombra roja que no cambia de tamaño */
    box-shadow: 0 4px 6px rgba(255, 0, 0, 0.7);  
}

.ho_dist {
    text-align: center; 
    margin-top: 10px; 
}

.services {
    padding: 10px;
    text-align: center;
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
                      
                        <li class="d_none"><i class="fa fa-phone" aria-hidden="true"></i>729 368 3094</a></li>
                        <li class="d_none"> <a href="#"><i class="fa fa-envelope" aria-hidden="true"></i>bolsatrabajo@umb.com</a></li>
                        <li class="d_none"> <a href="login.php">Login <i class="fa fa-user" aria-hidden="true"></i></a> </li>
                      
                        <li> <button class="openbtn" onclick="openNav()"><img src="images/menu_btn.png"></button></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- end header -->
      <!-- start slider section -->
      <div class=" banner_main">
         <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
               <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
               <li data-target="#myCarousel" data-slide-to="1"></li>
               <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="container">
                     <div class="carousel-caption relative">
                        <div class="bg_white">
                           <h1>BOLSA DE TRABAJO <span class="yello">UMB</span></h1>
                           <p>Aquí podrás encontrar una oportunidad de trabajo.</p>
                        </div>
                        
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="carousel-caption relative">
                        <div class="bg_white">
                           <h1>Bienvenido <span class="yello">Empresa</span></h1>
                           <p>Puedes registrarte como empresa para reclutar trabajadores. </p>
                        </div>
                       
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="carousel-caption relative">
                        <div class="bg_white">
                           <h1>Bienvenido <span class="yello">Usuario</span></h1>
                           <p>Puedes registrarte como usuario para conseguir un empleo.</p>
                        </div>
                        
                     </div>
                  </div>
               </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
         </div>
      </div>
      <!-- end slider section -->
      <!-- six_box-->
     <div id="about" class="about top_layer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="titlepage">
                    <h2><center>Vacantes Disponibles</center></h2>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="about_box">
                    <div class="row d_flex">
                        <div class="col-md-12">
                            <div class="about_box_text">
                                <center>
  <form method="GET" action="" class="form-container">
    <div class="form-group">
      <input type="text" name="puesto" placeholder="Buscar por puesto" value="<?= htmlspecialchars($_GET['puesto'] ?? '') ?>">
      <input type="text" name="habilidades" placeholder="Buscar por habilidades" value="<?= htmlspecialchars($_GET['habilidades'] ?? '') ?>">
      <input type="text" name="ubicacion" placeholder="Ubicación" value="<?= htmlspecialchars($_GET['ubicacion'] ?? '') ?>">
      <input type="number" name="salario_min" placeholder="Salario mínimo" value="<?= htmlspecialchars($_GET['salario_min'] ?? '') ?>">
      <input type="number" name="salario_max" placeholder="Salario máximo" value="<?= htmlspecialchars($_GET['salario_max'] ?? '') ?>">
    </div>
    <button class="read_more" type="submit">Buscar</button>
  </form>
</center>

        <br>
        <div class="vacantes">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($vacante = $result->fetch_assoc()): ?>
                    <div class="vacante">
                        <h3><?= htmlspecialchars($vacante['puesto']) ?></h3>
                       <p> <strong>Descripción:</strong> <?= htmlspecialchars($vacante['prestaciones']) ?></p>
                        <p><strong>Salario:</strong> <?= htmlspecialchars($vacante['salario']) ?></p>
                        <p><strong>Ubicación:</strong> <?= htmlspecialchars($vacante['direccion_empresa']) ?></p>
                        
                        <?php if ($usuarioLogueado): ?>
                            <form action="aplicar.php" method="POST">
                                <input type="hidden" name="id_vacante" value="<?= $vacante['id_vacante'] ?>">
                                <button type="submit" class="read_more">Aplicar</button>
                            </form>
                        <?php else: ?>
                            <p class="text-danger">Debe iniciar sesión para aplicar a esta vacante.</p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay vacantes disponibles.</p>
            <?php endif; ?>
                              
                           </div>
                        </div>
                        <div class=" col-md-7  pppp">
                           <div class="about_box_img">
                             
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end six_box-->
      <!-- building -->
      <div class="building">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>¿Buscas Trabajo? <br><span class="yello">Bol UMB es tu mejor aliado! <br></span> Miles de ofertas de empleo están esperándote</h2><br>
                    
                     <p> <img src="images/correcto.png" height="20" width="20"> Ofertas cada día.</p>
                       <p> <img src="images/correcto.png" height="20" width="20"> Alertas personalizadas .</p>
                         <p> <img src="images/correcto.png" height="20" width="20"> Completa tu perfil.</p>
                           <p> <img src="images/correcto.png" height="20" width="20"> Empleos que se ajustan a tu perfil.</p>
                             <p> <img src="images/correcto.png" height="20" width="20"> Muéstrate profesional y ganarás visibilidad.</p>
                    
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end building -->
      <!-- services -->
   <?php
require_once "conexion.php"; // Archivo de conexión

// Consulta para obtener los datos de las empresas
$query = "SELECT nombre_empresa, descripcion_empresa, imagen FROM empresa";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo '<div class="services_main">';
    echo '    <div class="container">';
    echo '        <div class="row">';
    echo '            <div class="col-md-12">';
    echo '                <div class="titlepage">';
    echo '                    <h2><center>Empresas</center></h2>';
    echo '                    <span>Estas son algunas de las empresas reclutadoras que forman parte de BOL UMB. </span>';
    echo '                </div>';
    echo '            </div>';
    echo '        </div>';
    echo '        <div class="row justify-content-center">'; 

   
    while ($row = $result->fetch_assoc()) {
        $nombre = htmlspecialchars($row['nombre_empresa']);
        $imagen = base64_encode($row['imagen']); 

        echo '            <div class="col-md-4 col-sm-6 mb-4">'; 
        echo '                <div class="services">';
        echo '                    <div class="services_img">';
        echo '                        <figure>';
        echo '                            <img class="circle-img" src="data:image/jpeg;base64,' . $imagen . '" alt="' . $nombre . '" />';
        echo '                        </figure>';
        echo '                        <div class="ho_dist">';
        echo '                            <span>' . $nombre . '</span>';
        echo '                        </div>';
        echo '                    </div>';
        echo '                </div>';
        echo '            </div>';
    }

    echo '        </div>';
    echo '    </div>';
    echo '</div>';
} else {
    echo '<p>No hay empresas registradas.</p>';
}

$conn->close();
?>



      <!-- end services -->
     
      <!-- footer -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class="col-md-10 offset-md-1">
                     <ul class="social_icon text_align_center">
                        <li> <a href="#"><i class="fa fa-facebook-f"></i></a></li>
                        <li> <a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li> <a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                        <li> <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
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
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
       <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
   </body>
</html>
