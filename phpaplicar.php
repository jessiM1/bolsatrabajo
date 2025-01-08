<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include 'conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aplicar'])) {
    $id_vacante = $_POST['id_vacante'];
    $id_buscador = $_POST['id_buscador']; 
    $fecha_postulacion = date('Y-m-d H:i:s');
   
    // Verificar si el usuario ya aplicó a esta vacante
    $query_check = "SELECT COUNT(*) AS total FROM postulaciones WHERE id_vacante = ? AND id_buscador = ?";
    $stmt_check = mysqli_prepare($conn, $query_check);
    mysqli_stmt_bind_param($stmt_check, 'ii', $id_vacante, $id_buscador);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    $row_check = mysqli_fetch_assoc($result_check);

    if ($row_check['total'] > 0) {
        // El usuario ya aplicó a esta vacante
 
        echo "<script>alert('Lo sentimos,Ya has aplicado a esta vacante.');</script>";
             echo '<script>window.location = "bienvenidousu.php";</script>';
        
    } else {
        // Si no ha aplicado, proceder con el registro
        if (!empty($_POST['cv_guardado'])) {
            $id_cv = $_POST['cv_guardado'];

            $query = "SELECT archivo_pdf FROM cv WHERE id_cv = ?";
            $stmt_cv = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt_cv, 'i', $id_cv);
            mysqli_stmt_execute($stmt_cv);
            $result_cv = mysqli_stmt_get_result($stmt_cv);
            $cv_row = mysqli_fetch_assoc($result_cv);
            $cvs = $cv_row['archivo_pdf'];

            // Insertar la postulación en la base de datos
            $query = "INSERT INTO postulaciones (id_vacante, id_buscador, cv, estatus, fecha_postulacion) 
                      VALUES (?, ?, ?, 'Pendiente', ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'iiss', $id_vacante, $id_buscador, $cvs, $fecha_postulacion);

            if (mysqli_stmt_execute($stmt)) {
             
             echo "<script>alert('Postulación registrada correctamente con CV guardado');</script>";
             echo '<script>window.location = "bienvenidousu.php";</script>';
            } else {
                
                echo "<script>alert('Postulación registrada correctamente con CV guardado');</script>";
             echo '<script>window.location = "bienvenidousu.php";</script>';
            }
        } elseif (isset($_FILES['cv_nuevo']) && $_FILES['cv_nuevo']['error'] === UPLOAD_ERR_OK) {
            // Validar que el archivo sea un PDF
            $fileType = mime_content_type($_FILES['cv_nuevo']['tmp_name']);
            if ($fileType === 'application/pdf') {
              
$uploadDir = 'cv_uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Generar un nombre único para el archivo
$fileName = uniqid('cv_') . '.pdf'; 
$filePath = $uploadDir . $fileName;

// Mover el archivo a la carpeta de subida
if (move_uploaded_file($_FILES['cv_nuevo']['tmp_name'], $filePath)) {
    // Insertar la postulación en la base de datos
    $query = "INSERT INTO postulaciones (id_vacante, id_buscador, cv, estatus, fecha_postulacion) 
              VALUES (?, ?, ?, 1, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'iiss', $id_vacante, $id_buscador, $fileName, $fecha_postulacion);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Postulación registrada correctamente con un nuevo CV.');</script>";
        echo '<script>window.location = "bienvenidousu.php";</script>';
    } else {
        echo "<script>alert('Error al registrar la postulación');</script>";
        echo '<script>window.location = "bienvenidousu.php";</script>';
    }
} else {
    echo "<script>alert('Error al guardar el archivo en el servidor.');</script>";
}

            } else {
              
                echo "<script>alert('Error: Solo se permiten archivos en formato PDF.');</script>";
                        echo '<script>window.location = "bienvenidousu.php";</script>';
            }
        } else {
            echo "<script>alert('No se seleccionó un CV guardado ni se subió uno nuevo.');</script>";
                        echo '<script>window.location = "bienvenidousu.php";</script>';
            
        }
    }
} else {
 
        echo "<script>alert('Error: No se recibieron los datos necesarios.');</script>";
                        echo '<script>window.location = "bienvenidousu.php";</script>';
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aplicar a Vacante</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2>Aplicar a Vacante</h2>
        <?php if ($mensaje != ''): ?>
            <div class="alert alert-info">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <a href="bienvenidousu.php" class="btn btn-secondary">Regresar a Vacantes</a>
    </div>
</body>
</html>


