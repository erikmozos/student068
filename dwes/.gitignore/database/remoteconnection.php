<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "hotel141124"; // Base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}
?>