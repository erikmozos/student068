<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');
?>

<?php
// Insertar nuevo cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert_cliente'])) {
    $dni_cliente = $_POST['customer_dni'];
    $nombre_cliente = $_POST['customer_name'];
    $apellidos_cliente = $_POST['customer_last_name'];
    $direccion_cliente = $_POST['customer_address'];
    $telefono_cliente = $_POST['phone_number'];
    $correo_cliente = $_POST['customer_email']; // Nuevo campo de correo electrónico
    $fecha_nacimiento_cliente = $_POST['customer_birthdate'];

    $sql = "INSERT INTO 068_customers (customer_name, customer_last_name, customer_dni, customer_address, phone_number, customer_email, customer_birthdate) 
            VALUES ('$nombre_cliente', '$apellidos_cliente', '$dni_cliente', '$direccion_cliente', '$telefono_cliente', '$correo_cliente', '$fecha_nacimiento_cliente')";

    if (mysqli_query($conn, $sql)) {
        echo "<p class='text-center text-green-600'>Nuevo cliente insertado correctamente.</p>";
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
    <title>Insertar Cliente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body>

<section class="reserva my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Insertar Cliente Nuevo</h2>
    <form action="" method="POST" class="max-w-lg mx-auto p-8 bg-white shadow-lg rounded-lg space-y-6">
        <div>
            <label for="customer_dni" class="block text-lg text-blue-800">DNI</label>
            <input type="text" id="customer_dni" name="customer_dni" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="customer_name" class="block text-lg text-blue-800">Nombre</label>
            <input type="text" id="customer_name" name="customer_name" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="customer_last_name" class="block text-lg text-blue-800">Apellidos</label>
            <input type="text" id="customer_last_name" name="customer_last_name" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="customer_address" class="block text-lg text-blue-800">Dirección</label>
            <input type="text" id="customer_address" name="customer_address" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="phone_number" class="block text-lg text-blue-800">Número de Teléfono</label>
            <input type="number" id="phone_number" name="phone_number" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="customer_email" class="block text-lg text-blue-800">Correo Electrónico</label>
            <input type="email" id="customer_email" name="customer_email" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="customer_birthdate" class="block text-lg text-blue-800">Fecha de Nacimiento</label>
            <input type="date" id="customer_birthdate" name="customer_birthdate" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <button type="submit" name="insert_cliente" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Insertar Cliente</button>
    </form>
</section>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>

<?php
// Cerrar la conexión
mysqli_close($conn);
?>
