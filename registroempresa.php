<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_empresa = $_POST['nombre_empresa'];
    $rfc_empresa = $_POST['rfc_empresa'];
    $direccion_empresa = $_POST['direccion_empresa'];
    $telefono_empresa = $_POST['telefono_empresa'];
    $descripcion_empresa = $_POST['descripcion_empresa'];
    $correo_empresa = $_POST['correo_empresa'];
    $nombre_reclutador = $_POST['nombre_reclutador'];
    $apaterno_reclutador = $_POST['apaterno_reclutador'];
    $amaterno_reclutador = $_POST['amaterno_reclutador'];
    $pass_empresa = password_hash($_POST['pass_empresa'], PASSWORD_BCRYPT);
    $foto = $_FILES['foto'];

    if ($foto['error'] === UPLOAD_ERR_OK) {
        $carpetaDestino = 'guardadas/';
        $nombreArchivo = basename($foto['name']);
        $rutaArchivo = $carpetaDestino . $nombreArchivo;

        if (move_uploaded_file($foto['tmp_name'], $rutaArchivo)) {
            $imagen = file_get_contents($rutaArchivo);

            $sql = "INSERT INTO empresa (nombre_empresa, rfc_empresa, direccion_empresa, telefono_empresa, descripcion_empresa, correo, nombre_reclutador, apaterno_reclutador, amaterno_reclutador, pass, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssss", $nombre_empresa, $rfc_empresa, $direccion_empresa, $telefono_empresa, $descripcion_empresa, $correo_empresa, $nombre_reclutador, $apaterno_reclutador, $amaterno_reclutador, $pass_empresa, $nombreArchivo);
            $stmt->execute();

            echo "<script>alert('Registro de empresa exitoso.');</script>";
            echo '<script>window.location = "login.php";</script>';
        } else {
            echo "<script>alert('Error al mover la foto al directorio.');</script>";
            echo '<script>window.location = "registroempresa.php";</script>';
        }
    } else {
        echo "<script>alert('No se ha subido ninguna foto o hubo un error en la carga.');</script>";
        echo '<script>window.location = "registroempresa.php";</script>';
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
      <title>Bol UMB</title>
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
                        <li class="d_none"> <a href="index.php">Inicio <i class="fa-3x" aria-hidden="true"></i></a> </li>
                      
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
                    <form method="POST" action="" class="form-horizontal" enctype="multipart/form-data">

                        <div class="header">Registro Empresa</div>
                        <div class="form-content">
                           <div class="form-group">
                                <div class="col-sm-10">

                                   <input type="text" name="nombre_empresa" placeholder="Nombre de la Empresa" required class="form-control">
                                </div>
                            </div>
                            
                             <div class="form-group">
                                <div class="col-sm-10">
                           <input type="text" name="rfc_empresa" placeholder="RFC de la Empresa" required class="form-control">
                                </div>
                            </div>
                            
                             <div class="form-group">
                                <div class="col-sm-10">
                            <label for="foto">Foto de Perfil:</label>
                                <input type="file" name="foto"  accept="image/*"> 
                                </div>
                            </div>  
                                
                            
                             <div class="form-group">
                                <div class="col-sm-12">
                          <input type="text" name="direccion_empresa" placeholder="Dirección" required class="form-control"> 
                                </div>
                            </div>
                            
                             <div class="form-group">
                                 <div class="col-sm-12">
                                <input type="text" name="telefono_empresa" placeholder="Teléfono" required class="form-control"> 
                                </div>
                            </div>
                            
                             <div class="form-group">
                                <div class="col-sm-12">
                                   <textarea name="descripcion_empresa" placeholder="Descripción" required class="form-control" ></textarea> 
                                </div>
                            </div>
                            
                             <div class="form-group">
                                <div class="col-sm-12">
                               <input type="email" name="correo_empresa" placeholder="Correo Electrónico" required class="form-control"> 
                                </div>
                            </div>
                            
                             <div class="form-group">
                                <div class="col-sm-12">
                                 <input type="text" name="nombre_reclutador" placeholder="Nombre del Reclutador" required  class="form-control"> 
                                </div>
                            </div>
                            
                             <div class="form-group">
                                <div class="col-sm-12">
                                <input type="text" name="apaterno_reclutador" placeholder="Apellido Paterno del Reclutador" required  class="form-control"> 
                                </div>
                            </div>
                            
                            
                             <div class="form-group">
                                <div clzass="col-sm-12">
                               <input type="text" name="amaterno_reclutador" placeholder="Apellido Materno del Reclutador" required class="form-control"> 
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-12">
                              <input type="password" name="pass_empresa" placeholder="Contraseña" required class="form-control"> 
                                </div>
                            </div>
                           <br>
                            <button type="submit" style="display: block; margin: 0 auto;" class="read_more">Registrar empresa</button>
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
