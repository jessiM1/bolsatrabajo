<?php
session_start();
require_once 'conexion.php';

// Verificar si el token se pasó por URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Función para validar el token
    function validarToken($token) {
        global $conn;

        // Sanitizar el token para evitar inyecciones SQL
        $token = mysqli_real_escape_string($conn, $token);

        // Verificar si el token existe y no ha expirado
        $query = "SELECT * FROM tokens WHERE token = '$token' AND expiracion > NOW() LIMIT 1";
        $resultado = mysqli_query($conn, $query);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_assoc($resultado);
        }

        return false;
    }

    $datos_token = validarToken($token);

    if ($datos_token) {
        // Mostrar el formulario para cambiar la contraseña
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nueva_contraseña = $_POST['nueva_contraseña'];

            // Sanitizar y encriptar la nueva contraseña
            $nueva_contraseña = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

            // Actualizar la contraseña según el tipo de usuario
            if ($datos_token['tipo_usuario'] == 'buscador') {
                $query = "UPDATE buscadores SET pass = '$nueva_contraseña' WHERE correo = '" . $datos_token['email'] . "'";
                mysqli_query($conn, $query);
            } else if ($datos_token['tipo_usuario'] == 'empresa') {
                $query = "UPDATE empresa SET pass= '$nueva_contraseña' WHERE correo = '" . $datos_token['email'] . "'";
                mysqli_query($conn, $query);
            }

            // Eliminar el token para evitar que se use nuevamente
            $query = "DELETE FROM tokens WHERE token = '$token'";
            mysqli_query($conn, $query);

            echo "<script>alert('Contraseña cambiada exitosamente.');</script>";
            echo '<script>window.location = "login.php";</script>'; // Redirigir al login
        }
    } else {
        echo "<script>alert('El token es inválido o ha expirado.');</script>";
        echo '<script>window.location = "recuperacontra.php";</script>';
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
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
    <style>

.form-bg{
    background: #e4e6e6;
}

form{
    font-family: 'Roboto', sans-serif;
}

.form-horizontal .header{
    background: #fe9a0c;
    padding: 30px 25px;
    font-size: 30px;
    color: #fff;
    text-align: center;
    text-transform: uppercase;
    border-radius: 3px 3px 0 0;
}

.form-horizontal .heading{
    font-size: 16px;
    color: #3f9cb5;
    margin: 10px 0 20px 0;
    text-transform: capitalize;
}

.form-horizontal .form-content{
    padding: 25px;
    background: #fff;
}

.form-horizontal .form-control{
    padding: 12px 16px 12px 39px;
    height: 50px;
    font-size: 14px;
    color: #2b2a2a;
    border: none;
    border-bottom: 2px solid #ccc;
    border-radius: 0;
    box-shadow: none;
    margin-bottom: 15px;
}

.form-horizontal .form-control:focus{
    border-color: #3f9cb5;
    box-shadow: none;
}
.demo
{
	padding: 100px 0;
}
.heading-title
{
	margin-bottom: 100px;
}
.form-horizontal .control-label{
    font-size: 17px;
    color: #ccc;
    position: absolute;
    top: 5px;
    left: 27px;
    text-align: center;
}

.form-horizontal textarea.form-control{
    resize: vertical;
    height: 130px;
}

.form-horizontal .btn{
    font-size: 18px;
    color: #4e4e4e;
    float: right;
    margin: 10px 0;
    border: 2px solid #ccc;
    border-radius: 0;
    padding: 10px 25px;
    transition: all 0.5s ease 0s;
}

.form-horizontal .btn:hover{
    background: #fff;
    border-color: #3f9cb5;
}@charset "utf-8";
/* CSS Document */
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
                        <li class="d_none"> <a href="index.php">Inicio <i  aria-hidden="true"></i></a> </li>
                      
                        <li> <button class="openbtn" onclick="openNav()"><img src="images/menu_btn.png"></button></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </header>
     
      <!-- services -->
      <div class="services_main">
         <div class="container">
           <div class="col-md-offset-3 col-md-6">
                   
                   <form method="POST" action="" class="form-horizontal">
                   <div class="header">Cambiar Contraseña</div>
                        <div class="form-content">
                           <div class="form-group">
                                <div class="col-sm-6">
                                  <label class="control-label" for="exampleInputName2"><i class="fa fa-lock"></i></label>
                                  <input type="password" id="nueva_contraseña" name="nueva_contraseña" placeholder="Nueva contraseña"  class="form-control" required>
           
             <div>
             </div>
            <button type="submit" class="read_more">Cambiar Contraseña</button>
             
        </form>
        
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
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
       <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
   </body>
</html>

