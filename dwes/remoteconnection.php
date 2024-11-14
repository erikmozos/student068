<?php
$servername = "remotehost.es"; 
$username = "student068";          
$password = "peri5543#";      
$database = "068_perihotel251024";                

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión remota ha fallado: " . $conn->connect_error);
}
?>
