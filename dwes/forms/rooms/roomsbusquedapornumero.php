<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "hotel"; // Base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Inicializar variables
$room_number = $_POST['room_number'];
$room_price = "";
$description = "";
$room_state = "";

// Obtener datos de la habitación
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_number = $_POST['room_number'];

    // Consulta para obtener la información de la habitación
    $sql = "SELECT * FROM rooms WHERE room_number = '$room_number'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $room_price = $row['room_price'];
        $description = $row['description'];
        $room_state = $row['room_state'];
    } else {
        echo "<p class='text-center text-red-600'>No se encontró la habitación con número $room_number.</p>";
    }
}

mysqli_close($conn);
?>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Habitación</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body>
<section class="reserva my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Editar Información de la Habitación</h2>
    <form action="roomsbusquedapornumero.php" method="POST" class="max-w-lg mx-auto p-8 bg-white shadow-lg rounded-lg space-y-6">
        <input type="hidden" name="room_number" value="<?php echo $room_number; ?>">
        <div>
            <label for="room_price" class="block text-lg text-blue-800">Precio de la Habitación</label>
            <input type="number" id="room_price" name="room_price" value="<?php echo $room_price; ?>" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="description" class="block text-lg text-blue-800">Descripción</label>
            <textarea id="description" name="description" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500"><?php echo $description; ?></textarea>
        </div>
        <div>
            <label for="room_state" class="block text-lg text-blue-800">Estado</label>
            <select id="room_state" name="room_state" class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
                <option value="disponible" <?php if ($room_state == 'disponible') echo 'selected'; ?>>Disponible</option>
                <option value="ocupada" <?php if ($room_state == 'ocupada') echo 'selected'; ?>>Ocupada</option>
                <option value="mantenimiento" <?php if ($room_state == 'mantenimiento') echo 'selected'; ?>>Mantenimiento</option>
            </select>
        </div>
        <button type="submit" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Actualizar Habitación</button>
    </form>
</section>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>
