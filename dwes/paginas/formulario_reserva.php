<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');

// Obtener valores desde las cookies y la sesión
$room_id = isset($_COOKIE['room']) ? $_COOKIE['room'] : null;
$check_in = isset($_COOKIE['check_in']) ? $_COOKIE['check_in'] : null;
$check_out = isset($_COOKIE['check_out']) ? $_COOKIE['check_out'] : null;
$guests = isset($_COOKIE['personas']) ? $_COOKIE['personas'] : null;
$customer_id = $_SESSION['id']; // ID del cliente obtenido de la sesión

// Validar campos obligatorios
if (empty($room_id) || empty($check_in) || empty($check_out) || empty($guests) || empty($customer_id)) {
    echo "
    <div class='container mx-auto my-16 px-6 min-h-screen'>
        <h2 class='text-3xl text-red-500 text-center'>La sesión ha finalizado.</h2>
    </div>";
    exit();
}

// Validar que el ID de la habitación y el ID del cliente sean números
if (!filter_var($room_id, FILTER_VALIDATE_INT) || !filter_var($customer_id, FILTER_VALIDATE_INT)) {
    echo "
    <div class='container mx-auto my-16 px-6 min-h-screen'>
        <h2 class='text-3xl text-red-500 text-center'>Error: ID de habitación o cliente no válido.</h2>
    </div>";
    exit();
}

// Generar un número de reserva único
$reservation_number = rand(1000000000, 2147483647);

// Calcular el precio de la reserva
$sql_price = "SELECT price_per_night FROM 068_room_type_view2 WHERE room_id = ?";
$stmt_price = $conn->prepare($sql_price);

if (!$stmt_price) {
    echo "
    <div class='container mx-auto my-16 px-6 min-h-screen'>
        <h2 class='text-3xl text-red-500 text-center'>Error al obtener el precio: " . $conn->error . "</h2>
    </div>";
    exit();
}

$stmt_price->bind_param("i", $room_id);
$stmt_price->execute();
$result_price = $stmt_price->get_result();
$row_price = $result_price->fetch_assoc();

if ($row_price) {
    $price_per_night = $row_price['price_per_night'];

    try {
        $date_in = new DateTime($check_in);
        $date_out = new DateTime($check_out);
    } catch (Exception $e) {
        echo "
        <div class='container mx-auto my-16 px-6 min-h-screen'>
            <h2 class='text-3xl text-red-500 text-center'>Formato de fecha no válido. Revisa las fechas ingresadas.</h2>
        </div>";
        exit();
    }

    $days = $date_in->diff($date_out)->days;

    if ($days <= 0) {
        echo "
        <div class='container mx-auto my-16 px-6 min-h-screen'>
            <h2 class='text-3xl text-red-500 text-center'>La fecha de salida debe ser posterior a la de entrada.</h2>
        </div>";
        exit();
    }

    $reservation_price = $days * $price_per_night;
} else {
    echo "
    <div class='container mx-auto my-16 px-6 min-h-screen'>
        <h2 class='text-3xl text-red-500 text-center'>No se pudo calcular el precio de la reserva.</h2>
    </div>";
    exit();
}

// Insertar la reserva en la base de datos
$sql_insert = "INSERT INTO 068_reservations (room_id, customer_id, reservation_number, date_in, date_out, number_of_customers, reservation_price, extras_json, status) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'reserved')";
$stmt_insert = $conn->prepare($sql_insert);

if (!$stmt_insert) {
    echo "
    <div class='container mx-auto my-16 px-6 min-h-screen'>
        <h2 class='text-3xl text-red-500 text-center'>Error al crear la consulta de inserción: " . $conn->error . "</h2>
    </div>";
    exit();
}

$extras_json = json_encode(["services" => []]); // Por defecto, no se incluyen servicios adicionales
$stmt_insert->bind_param("iiissids", $room_id, $customer_id, $reservation_number, $check_in, $check_out, $guests, $reservation_price, $extras_json);

if ($stmt_insert->execute()) {
    echo "
    <div class='container mx-auto my-16 px-6 min-h-screen'>
        <h2 class='text-3xl text-green-500 text-center'>¡Reserva creada con éxito!</h2>
        <p class='text-lg text-center'>Número de reserva: <span class='font-bold'>$reservation_number</span></p>
        <p class='text-lg text-center'>Precio total: <span class='font-bold'>\$$reservation_price</span></p>
        <div class='text-center mt-8'>
            <a href='/student068/dwes/index.php' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>Volver al inicio</a>
        </div>
    </div>";
} else {
    echo "
    <div class='container mx-auto my-16 px-6 min-h-screen'>
        <h2 class='text-3xl text-red-500 text-center'>Error al crear la reserva: " . $conn->error . "</h2>
    </div>";
}

// Cerrar conexiones
$stmt_insert->close();
$stmt_price->close();
$conn->close();

include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>
