<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');

// Verificar si se pasa un room_id y otras variables de reserva
if (isset($_POST['room_id'], $_POST['check-in'], $_POST['check-out'], $_POST['guests'])) {
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check-in'];
    $check_out = $_POST['check-out'];
    $guests = (int) $_POST['guests'];
} else {
    echo "Faltan datos para completar la reserva.";
    exit();
}

include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
?>

<div class="container mx-auto my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Formulario de Reserva</h2>
    
    <!-- Formulario de reserva con campos adicionales -->
    <form action="insertarReserva.php" method="post">
        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
        <input type="hidden" name="check-in" value="<?php echo $check_in; ?>">
        <input type="hidden" name="check-out" value="<?php echo $check_out; ?>">
        <input type="hidden" name="guests" value="<?php echo $guests; ?>">

        <!-- Nombre -->
        <div class="mb-4">
            <label for="customer_name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" id="customer_name" name="customer_name" required class="mt-1 p-2 w-full border border-gray-300 rounded-md">
        </div>

        <!-- Apellido -->
        <div class="mb-4">
            <label for="customer_last_name" class="block text-sm font-medium text-gray-700">Apellido</label>
            <input type="text" id="customer_last_name" name="customer_last_name" required class="mt-1 p-2 w-full border border-gray-300 rounded-md">
        </div>

        <!-- DNI -->
        <div class="mb-4">
            <label for="customer_dni" class="block text-sm font-medium text-gray-700">DNI</label>
            <input type="text" id="customer_dni" name="customer_dni" required class="mt-1 p-2 w-full border border-gray-300 rounded-md">
        </div>

        <!-- Dirección -->
        <div class="mb-4">
            <label for="customer_address" class="block text-sm font-medium text-gray-700">Dirección</label>
            <input type="text" id="customer_address" name="customer_address" required class="mt-1 p-2 w-full border border-gray-300 rounded-md">
        </div>

        <!-- Teléfono -->
        <div class="mb-4">
            <label for="phone_number" class="block text-sm font-medium text-gray-700">Número de teléfono</label>
            <input type="tel" id="phone_number" name="phone_number" required class="mt-1 p-2 w-full border border-gray-300 rounded-md">
        </div>

        <!-- Correo Electrónico -->
        <div class="mb-4">
            <label for="customer_email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
            <input type="email" id="customer_email" name="customer_email" required class="mt-1 p-2 w-full border border-gray-300 rounded-md">
        </div>

        <!-- Fecha de Nacimiento -->
        <div class="mb-4">
            <label for="customer_birthdate" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
            <input type="date" id="customer_birthdate" name="customer_birthdate" required class="mt-1 p-2 w-full border border-gray-300 rounded-md">
        </div>

        <!-- Botón de Envío -->
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Completar Reserva
        </button>
    </form>
</div>
