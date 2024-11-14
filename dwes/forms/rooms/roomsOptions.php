
<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Habitaciones</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body>
<section class="reserva my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Ver Habitación / Editar Habitación</h2>
    <form action="<?php echo '/student068/dwes/forms/rooms/selectRoomById.php'; ?>" method="POST" class="max-w-lg mx-auto p-8 bg-white shadow-lg rounded-lg space-y-6">
        <div>
            <label for="room_number" class="block text-lg text-blue-800">Número de Habitación</label>
            <input type="number" id="room_number" name="room_number" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <button type="submit" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Ver Información</button>
    </form>
</section>

<section class="reserva my-16 px-6 space-y-6 max-w-lg mx-auto">
    <form action="<?php echo '/student068/dwes/forms/rooms/selectRoomsAll.php'; ?>">
        <button type="submit" class="w-full bg-green-500 text-white p-3 rounded-lg hover:bg-green-600 transition-colors">Ver Todas las Habitaciones</button>
    </form>

    <form action="<?php echo '/student068/dwes/forms/rooms/roomsdisponibles.php'; ?>">
        <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 transition-colors">Ver Habitaciones Disponibles</button>
    </form>

    <form action="<?php echo '/student068/dwes/forms/rooms/roomsocupadas.php'; ?>">    
        <button type="submit" class="w-full bg-red-500 text-white p-3 rounded-lg hover:bg-red-600 transition-colors">Ver Habitaciones Ocupadas</button>
    </form>

    <form action="<?php echo '/student068/dwes/forms/rooms/roomsinsert.php'; ?>">
        <button type="submit" class="w-full bg-purple-500 text-white p-3 rounded-lg hover:bg-purple-600 transition-colors">Insertar Nueva Habitación</button>
    </form>

    <form action="<?php echo '/student068/dwes/forms/rooms/roomsdelete.php'; ?>">
    <button type="submit" class="w-full bg-gray-600 text-white p-3 rounded-lg hover:bg-gray-700 transition-colors">Eliminar Habitación</button>
    </form>
</section>

</body>
</html>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>
