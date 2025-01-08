<?php
session_start();
require_once 'conexion.php';

// Verificar si el formulario se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['email'];

    // Función para verificar si el correo existe en las tablas de "buscador" o "empresa"
    function verificarCorreo($correo) {
        global $conn;

        // Sanitizar el correo para evitar inyecciones SQL
        $correo = mysqli_real_escape_string($conn, $correo);

        // Verificar si el correo pertenece a un "buscador"
        $query_buscar = "SELECT correo FROM buscadores WHERE correo = '$correo' LIMIT 1";
        $resultado_buscar = mysqli_query($conn, $query_buscar);

        // Verificar si el correo pertenece a una "empresa"
        $query_empresa = "SELECT correo FROM empresa WHERE correo = '$correo' LIMIT 1";
        $resultado_empresa = mysqli_query($conn, $query_empresa);

        return mysqli_num_rows($resultado_buscar) > 0 || mysqli_num_rows($resultado_empresa) > 0;
    }

    // Función para generar un token
    function generarToken($correo) {
        global $conn;

        $token = bin2hex(random_bytes(16)); // Generar un token aleatorio
        $expiracion = date("Y-m-d H:i:s", strtotime("+1 hour")); // 1 hora de expiración

        // Determinar el tipo de usuario (buscador o empresa)
        $tipo_usuario = '';
        $query_buscar = "SELECT correo FROM buscadores WHERE correo = '$correo' LIMIT 1";
        $resultado_buscar = mysqli_query($conn, $query_buscar);
        if (mysqli_num_rows($resultado_buscar) > 0) {
            $tipo_usuario = 'buscador';
        } else {
            $query_empresa = "SELECT correo FROM empresa WHERE correo = '$correo' LIMIT 1";
            $resultado_empresa = mysqli_query($conn, $query_empresa);
            if (mysqli_num_rows($resultado_empresa) > 0) {
                $tipo_usuario = 'empresa';
            }
        }

        // Si no se encuentra el correo, no se genera el token
        if ($tipo_usuario) {
            // Guardar el token en la base de datos
            $query = "INSERT INTO tokens (token, expiracion, email, tipo_usuario) 
                      VALUES ('$token', '$expiracion', '$correo', '$tipo_usuario')";
            mysqli_query($conn, $query);
        }

        return $token;
    }

    // Verificar si el correo está registrado
    if (verificarCorreo($correo)) {
        // Generar el token
        $token = generarToken($correo);
        // Redirigir al usuario a la página de cambio de contraseña, pasando el token en la URL
        echo "<script>alert('Autenticación exitosa.');</script>";
        echo '<script>window.location = "cambiarcontra.php?token=' . $token . '";</script>';
    } else {
        echo "<script>alert('El correo no está registrado');</script>";
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

.parent-container {
    display: flex;
    justify-content: center; /* Centra horizontalmente */
    align-items: center;    /* Centra verticalmente (opcional) */
   
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
        <div class="parent-container">
                   <form method="POST" action="" class="form-horizontal">
                   <div class="header">Recuperar Contraseña</div>
                        <div class="form-content">
                           <div class="form-group">
                                <div class="col-sm-10">
                                 <label   class="control-label" for="exampleInputName2"><i class="fa fa-envelope-o"></i></label>
             <input   type="email"   name="email" class="form-control" placeholder="Email" id="email" required>
             <div>
             </div>
             <br>
            <button type="submit" name="recuperar"   class="read_more" style="display: block; margin: 0 auto;">Autenticar</button>
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

