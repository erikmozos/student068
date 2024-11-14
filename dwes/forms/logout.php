<?php
session_start(); // Inicia la sesión
session_unset(); // Libera todas las variables de sesión
session_destroy(); // Destruye la sesión

// Redirige al usuario a la página de inicio
header("Location: /student068/dwes/index.php"); // Cambia esto si necesitas redirigir a otra página
exit();
?>
