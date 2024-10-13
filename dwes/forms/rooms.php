<?php 

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, '', 'hotel');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>

?>

<div>
    <form action="<?php echo '/student068/dwes/forms/roomsaction.php' ?>" method="POST" class="max-w-lg mx-auto p-8 bg-white shadow-lg rounded-lg space-y-6">
        <div>
            <label for="check-in" class="block text-lg text-blue-800">Room id</label>
            <input type="number" id="room_id" name="room_id" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
    </form>
</div>
