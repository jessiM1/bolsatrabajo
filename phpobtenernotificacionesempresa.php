<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php'; 
session_start();

$empresa_id = $_SESSION['empresa_id'];





$mm='0';



/*  Consulta las notificaciones no leídas
$sql = "SELECT v.id_empresa AS id_e,n.id_ne,n.mensaje,v.puesto,n.fecha FROM notificaciones_empresa n
JOIN vacantes v ON n.id_vacante=v.id_vacante
 WHERE id_e = ? AND leida = 0 ORDER BY fecha DESC"; */
// Consulta las notificaciones no leídas
$sql = "SELECT e.id_e AS id_e,n.id_ne,n.mensaje,v.puesto,n.fecha FROM notificaciones_empresa n
JOIN vacantes v ON n.id_vacante=v.id_vacante
JOIN empresa e ON v.id_empresa=e.id_e
 WHERE id_e = ? AND leida = 0 ORDER BY fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $empresa_id);
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
