<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "hotel";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Eliminar habitación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_room'])) {
    $room_number = $_POST['room_number'];

    $sql = "DELETE FROM rooms WHERE room_number = '$room_number'";

    if (mysqli_query($conn, $sql)) {
        echo "<p class='text-center text-green-600'>Habitación eliminada correctamente.</p>";
    } else {
        echo "<p class='text-center text-red-600'>Error al eliminar la habitación: " . mysqli_error($conn) . "</p>";
    }
}
?>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Habitación</title>
</head>
<body>

<section class="reserva my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Eliminar Habitación</h2>
    <form action="" method="POST" class="max-w-lg mx-auto p-8 bg-white shadow-lg rounded-lg space-y-6">
        <div>
            <label for="room_number" class="block text-lg text-blue-800">Número de Habitación a Eliminar</label>
            <input type="number" id="room_number" name="room_number" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <button type="submit" name="delete_room" class="w-full bg-red-500 text-white p-3 rounded-lg hover:bg-red-600 transition-colors">Eliminar Habitación</button>
    </form>
</section>

</body>
</html>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>

<?php
// Cerrar la conexión
mysqli_close($conn);
?>
