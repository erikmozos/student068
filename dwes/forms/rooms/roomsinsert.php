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

// Insertar nueva habitación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert_room'])) {
    $room_number = $_POST['room_number'];
    $room_price = $_POST['room_price'];
    $description = $_POST['description'];
    $room_state = $_POST['room_state'];

    $sql = "INSERT INTO rooms (room_number, room_price, description, room_state) VALUES ('$room_number', '$room_price', '$description', '$room_state')";

    if (mysqli_query($conn, $sql)) {
        echo "<p class='text-center text-green-600'>Nueva habitación insertada correctamente.</p>";
    } else {
        echo "<p class='text-center text-red-600'>Error al insertar la habitación: " . mysqli_error($conn) . "</p>";
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
    <title>Insertar Nueva Habitación</title>
</head>
<body>

<section class="reserva my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Insertar Nueva Habitación</h2>
    <form action="" method="POST" class="max-w-lg mx-auto p-8 bg-white shadow-lg rounded-lg space-y-6">
        <div>
            <label for="room_number" class="block text-lg text-blue-800">Número de Habitación</label>
            <input type="number" id="room_number" name="room_number" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="room_price" class="block text-lg text-blue-800">Precio</label>
            <input type="number" id="room_price" name="room_price" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="description" class="block text-lg text-blue-800">Descripción</label>
            <textarea id="description" name="description" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500"></textarea>
        </div>
        <div>
            <label for="room_state" class="block text-lg text-blue-800">Estado</label>
            <select id="room_state" name="room_state" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
                <option value="disponible">Disponible</option>
                <option value="ocupada">Ocupada</option>
            </select>
        </div>
        <button type="submit" name="insert_room" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Insertar Habitación</button>
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
