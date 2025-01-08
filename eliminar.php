<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>
<?php
session_start();
require_once 'conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['correo'])) {
    header('Location: login.php'); // Redirigir al login si no está autenticado
    exit();
}
$correo = $_SESSION['correo'];

// Eliminar el CV si se solicita
if (isset($_GET['accion'], $_GET['id']) && $_GET['accion'] === 'eliminar1') {
    $idInfo = intval($_GET['id']); // Sanitizar el ID recibido

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // Verificar si el CV pertenece al usuario
        $queryVerificar = "SELECT i.id_info 
                           FROM informacion_personal i 
                           JOIN buscadores b ON i.id_buscador = b.id_buscador 
                           WHERE i.id_info = ? AND b.correo = ?";
        $stmt = $conn->prepare($queryVerificar);
        $stmt->bind_param('is', $idInfo, $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Eliminar registros relacionados
            $queries = [
                "DELETE FROM cv WHERE id_info = ?",
                "DELETE FROM informacion_personal WHERE id_info = ?",
                "DELETE FROM experiencia_laboral WHERE id_info = ?",
                "DELETE FROM formacion_academica WHERE id_info = ?"
            ];

            foreach ($queries as $query) {
                $stmt = $conn->prepare($query);
                $stmt->bind_param('i', $idInfo);
                if (!$stmt->execute()) {
                    throw new Exception('Error al eliminar registros.');
                }
            }

            // Confirmar transacción
            $conn->commit();
            echo "<script>alert('CV eliminado correctamente.');</script>";
        } else {
            echo "<script>alert('No tienes permiso para eliminar este CV.');</script>";
        }
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        $conn->rollback();
        echo "<script>alert('Error al eliminar el CV: {$e->getMessage()}');</script>";
    } finally {
        $stmt->close();
    }
	header('Location: mis_cvs.php');

    exit();
}
?>
</body>
</html>