<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $tipo = $_POST['tipo'];

    if ($tipo === 'experiencia') {
        $query = "DELETE FROM experiencia_laboral WHERE id_ex = ?";
    } elseif ($tipo === 'educacion') {
        $query = "DELETE FROM formacion_academica WHERE id = ?";
    } else {
        echo 'error';
        exit;
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
}
?>
