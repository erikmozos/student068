<?php
$servername = "remoteserver.com"; // Cambia esto por tu servidor remoto
$username = "remote_user";          // Cambia esto por tu usuario remoto
$password = "remote_password";      // Cambia esto por tu contraseña remota
$database = "hotel";                // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión remota ha fallado: " . $conn->connect_error);
}
?>
