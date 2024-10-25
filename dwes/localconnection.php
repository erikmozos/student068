<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "hotel";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión local ha fallado: " . $conn->connect_error);
}
?>
