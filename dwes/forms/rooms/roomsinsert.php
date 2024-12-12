<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');

if ($_SESSION['userrole'] !== "admin" && $_SESSION['userrole'] !== "employee") {
    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: /student068/dwes/index.php");
    exit();
}


// Insertar nueva habitación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert_room'])) {
    $room_number = $_POST['room_number'];
    $room_price = $_POST['room_price'];
    $description = $_POST['description'];
    $room_state = $_POST['room_state'];
    $room_floor = $_POST['room_floor'];  // Nuevo campo para el piso
    $room_type_id = $_POST['room_type_id'];

    // Validación: Verificar si el número de habitación ya existe
    $check_sql = "SELECT * FROM 068_rooms WHERE room_number = '$room_number'";
    $result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<p class='text-center text-red-600'>El número de habitación ya existe.</p>";
    } else {
        // Insertar nueva habitación con room_floor
        $sql = "INSERT INTO 068_rooms (room_number, room_price, description, room_state, room_floor, room_type_id) 
                VALUES ('$room_number', '$room_price', '$description', '$room_state', '$room_floor', '$room_type_id')";

        if (mysqli_query($conn, $sql)) {
            echo "<p class='text-center text-green-600'>Nueva habitación insertada correctamente.</p>";
        } else {
            echo "<p class='text-center text-red-600'>Error al insertar la habitación: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>

<?php
// Obtener los tipos de habitación para el dropdown
$type_sql = "SELECT room_type_id, type_name FROM 068_room_types";
$type_result = mysqli_query($conn, $type_sql);
?>


<!DOCTYPE html>
<html lang="es">
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
            <label for="room_floor" class="block text-lg text-blue-800">Piso</label> <!-- Nuevo campo para el piso -->
            <input type="number" id="room_floor" name="room_floor" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
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
                <option value="mantenimiento">En Mantenimiento</option>
            </select>
        </div>
        <div>
            <label for="room_type_id" class="block text-lg text-blue-800">Tipo de Habitación</label>
            <select id="room_type_id" name="room_type_id" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
                <option value="">Seleccione un tipo</option>
                <?php
                if (mysqli_num_rows($type_result) > 0) {
                    while($row = mysqli_fetch_assoc($type_result)) {
                        echo "<option value='" . $row['room_type_id'] . "'>" . $row['type_name'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <button type="submit" name="insert_room" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Insertar Habitación</button>
    </form>
</section>

<?php
// Incluir el footer
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>

</body>
</html>

<?php
// Cerrar la conexión
mysqli_close($conn);
?>
