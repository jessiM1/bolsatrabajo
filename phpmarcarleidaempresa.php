<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id_ne'])) {
        $id_notificacion = $input['id_ne'];
	    
        require_once 'conexion.php';

        if ($conn->connect_error) {
            echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos']);
            exit;
        }

        $stmt = $conn->prepare("UPDATE notificaciones_empresa SET leida = 1 WHERE id_ne= ? ");
        $stmt->bind_param('i',$id_notificacion);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al actualizar la notificación']);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'ID de vacante no proporcionado']);
    }
}
?>
