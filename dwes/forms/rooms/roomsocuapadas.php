<?php

$servername = "localhost";
$username = "root";
$password = "";
// Create connection
$conn = new mysqli($servername, $username, $password, 'hotel');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//Query
$sql = "select * from rooms where room_state = 'ocupada'";
$result = mysqli_query($conn, $sql);

include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');

while ($row = mysqli_fetch_assoc($result)) {
  echo "Room Name: " . $row['room_number'] . "<br>";
  echo "Room Price: " . $row['room_price'] . "<br>";
  echo "----------------------" . "<br>";
}

 mysqli_close($conn);
?>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>