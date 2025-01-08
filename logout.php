<?php
session_start(); // Inicia la sesión para poder acceder a las variables de sesión

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión
session_destroy();

// Redirige al usuario a la página de inicio de sesión o inicio
header("Location: index.php");
exit(); // Asegúrate de que no se ejecute ningún código adicional
?>
