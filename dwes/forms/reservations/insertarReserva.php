<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');
?>

<?php

// Insertar nueva reserva
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert_reservation'])) {
    $reservation_number = $_POST['reservation_number'];
    $date_in = $_POST['date_in'];
    $date_out = $_POST['date_out'];
    $number_of_customers = $_POST['number_of_customers'];
    $reservation_price = $_POST['reservation_price'];
    $extras = $_POST['extras'];

    $sql = "INSERT INTO 068_reservations (reservation_number, date_in, date_out, number_of_customers, reservation_price, extras) 
            VALUES ('$reservation_number', '$date_in', '$date_out', '$number_of_customers', '$reservation_price', '$extras')";

    if (mysqli_query($conn, $sql)) {
        echo "<p class='text-center text-green-600'>Nueva reserva insertada correctamente.</p>";
    } else {
        echo "<p class='text-center text-red-600'>Error al insertar la reserva: " . mysqli_error($conn) . "</p>";
    }
}
?>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
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
        <div>
            <label for="extras" class="block text-lg text-blue-800">Extras</label>
            <textarea id="extras" name="extras" class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500"></textarea>
        </div>
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
