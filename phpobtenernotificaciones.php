<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php'; 
session_start();

$correo = $_SESSION['correo']; // ID del buscador logueado
$queryID = "SELECT * FROM buscadores WHERE correo = '$correo'";
    $resultID = mysqli_query($conn, $queryID);
    if ($resultID) {
        while ($row = mysqli_fetch_assoc($resultID)) {
            $id_buscador =$row['id_buscador'];
        }
    }
	

// Consulta las notificaciones no leídas
$sql = "SELECT n.id_notificacion,n.mensaje,v.puesto, fecha FROM notificaciones n
JOIN vacantes v ON n.id_vacante=v.id_vacante
 WHERE id_buscador = ? AND leida = 0 ORDER BY fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_buscador);
$stmt->execute();
$resultado = $stmt->get_result();

// Convertir resultados a JSON
$notificaciones = [];
while ($fila = $resultado->fetch_assoc()) {
    $notificaciones[] = $fila;
}

// Devolver datos como JSON
header('Content-Type: application/json');
echo json_encode($notificaciones);  // Depuración
exit;  // Asegúrate de que no haya más salida


?>
