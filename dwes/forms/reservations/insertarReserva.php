<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');


if ($_SESSION['userrole'] !== "admin" && $_SESSION['userrole'] !== "employee") {
    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: /student068/dwes/index.php");
    exit();
}


// Insertar nueva reserva
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert_reservation'])) {
    $reservation_number = $_POST['reservation_number'];
    $date_in = $_POST['date_in'];
    $date_out = $_POST['date_out'];
    $number_of_customers = $_POST['number_of_customers'];
    $reservation_price = $_POST['reservation_price'];
    // $extras = isset($_POST['extras']) && !empty(trim($_POST['extras'])) ? trim($_POST['extras']) : '{}';
    $extras = "";
    $customer_id = $_POST['customer_id'];
    $room_id = $_POST['room_id']; // Obtener el room_id del formulario

    // Comprobar que el `customer_id` existe en la tabla `068_customers`
    $customer_check_sql = "SELECT * FROM 068_customers WHERE customer_id = '$customer_id'";
    $customer_check_result = mysqli_query($conn, $customer_check_sql);

    // Comprobar que el `room_id` existe en la tabla `068_rooms`
    $room_check_sql = "SELECT * FROM 068_rooms WHERE room_id = '$room_id'";
    $room_check_result = mysqli_query($conn, $room_check_sql);

    if (mysqli_num_rows($customer_check_result) > 0 && mysqli_num_rows($room_check_result) > 0) {
        // Si el cliente y la habitación existen, realiza la inserción
        $sql = "INSERT INTO 068_reservations (reservation_number, date_in, date_out, number_of_customers, reservation_price,  customer_id, room_id, status) 
                VALUES ('$reservation_number', '$date_in', '$date_out', '$number_of_customers', '$reservation_price', '$customer_id', '$room_id', 'reserved')";

        if (mysqli_query($conn, $sql)) {
            echo "<p class='text-center text-green-600'>Nueva reserva insertada correctamente.</p>";
        } else {
            echo "<p class='text-center text-red-600'>Error al insertar la reserva: " . mysqli_error($conn) . "</p>";
        }
    } else {
        // Si no se encuentra el `customer_id` o `room_id`, muestra un mensaje de error
        echo "<p class='text-center text-red-600'>Error: El ID del cliente o de la habitación no existe en la base de datos.</p>";
    }
}


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Nueva Reserva</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body>

<section class="reserva my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Insertar Nueva Reserva</h2>
    <form action="" method="POST" class="max-w-lg mx-auto p-8 bg-white shadow-lg rounded-lg space-y-6">
        <div>
            <label for="reservation_number" class="block text-lg text-blue-800">Número de Reserva</label>
            <input type="text" id="reservation_number" name="reservation_number" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="room_id" class="block text-lg text-blue-800">ID de la Habitación</label>
            <input type="number" id="room_id" name="room_id" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="customer_id" class="block text-lg text-blue-800">Id del cliente</label>
            <input type="number" id="customer_id" name="customer_id" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="date_in" class="block text-lg text-blue-800">Fecha de Entrada</label>
            <input type="date" id="date_in" name="date_in" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="date_out" class="block text-lg text-blue-800">Fecha de Salida</label>
            <input type="date" id="date_out" name="date_out" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="number_of_customers" class="block text-lg text-blue-800">Número de Clientes</label>
            <input type="number" id="number_of_customers" name="number_of_customers" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="reservation_price" class="block text-lg text-blue-800">Precio de la Reserva</label>
            <input type="number" id="reservation_price" name="reservation_price" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <!-- <div>
            <label for="extras" class="block text-lg text-blue-800">Extras</label>
            <textarea id="extras" name="extras" class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500"></textarea>
        </div> -->
        <button type="submit" name="insert_reservation" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Insertar Reserva</button>
    </form>
</section>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>

<?php
// Cerrar la conexión
mysqli_close($conn);
?>
