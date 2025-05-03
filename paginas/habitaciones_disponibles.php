<?php

$check_in = $_POST['check-in'];
$check_out = $_POST['check-out'];
$personas = $_POST['guests'];

echo gettype('$check_in');

echo "<br> Check-in: $check_in <br>";
echo "Check-out: $check_out <br>";
echo "Numero de persona: $personas";


$check_in = $_GET['check-in'];
$check_out = $_GET['check-out'];
$personas = $_GET['guests'];

echo gettype($check_in); 

echo "<br> Check-in: $check_in <br>";
echo "Check-out: $check_out <br>";
echo "Numero de personas: $personas";


// $servername = "localhost";
// $username = "root";
// $password = "";

// // Create connection
// $conn = new mysqli($servername, $username, $password, 'hotel');

// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }
// ?>
