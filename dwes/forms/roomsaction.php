<?php

$servername = "localhost";
$username = "root";
$password = "";
$room_id = $_POST['room_id']; 
// Create connection
$conn = new mysqli($servername, $username, $password, 'hotel');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$sql = "select * from rooms where room_id = {$room_id};";
$result = mysqli_query($conn ,$sql);

echo $result;



?>