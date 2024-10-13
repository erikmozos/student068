<!-- <?php 

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, '', 'hotel');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
?>-->


<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Form</title>
</head>
<body>
<section class="reserva my-16 px-6">
            <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Ver habitación</h2>
                <form action="<?php echo '/student068/dwes/forms/rooms/roomsaction.php'; ?>" method="POST" class="max-w-lg mx-auto p-8 bg-white shadow-lg rounded-lg space-y-6">
                    <div>
                        <label for="habitación" class="block text-lg text-blue-800">Numero de habitación</label>
                        <input type="number" id="room_number" name="room_number" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
                    </div>
                    <button type="submit" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Ver información</button>
                </form>
        </section>
        <section class="reserva my-16 px-6 space-y-6 max-w-lg mx-auto p-8">
            <form action="<?php echo '/student068/dwes/forms/rooms/roomsdisponibles.php'; ?>">
                <button type="submit" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Ver habitaciones disponibles</button>
            </form>
            <form action="<?php echo '/student068/dwes/forms/rooms/roomsocuapadas.php'; ?>">    
                <button type="submit" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Ver habitaciones ocupadas</button>
            </form>
        </section>
</body>
</html>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>