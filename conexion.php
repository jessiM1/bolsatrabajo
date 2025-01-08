<?php
$host = 'localhost';
$dbname = 'bolsatrabajo';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);


if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
