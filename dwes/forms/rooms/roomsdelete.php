<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');
?>

<?php

// Eliminar habitación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_room'])) {
    $room_number = $_POST['room_number'];
    
    // Disable foreign key checks, delete, and re-enable foreign key checks if needed
    $sql_disable_fk = "SET FOREIGN_KEY_CHECKS=0;";
    $sql_delete_room = "DELETE FROM 068_rooms WHERE room_number = '$room_number';";
    $sql_enable_fk = "SET FOREIGN_KEY_CHECKS=1;";

    // Execute disable FK, delete, and enable FK
    if (mysqli_query($conn, $sql_disable_fk) && mysqli_query($conn, $sql_delete_room) && mysqli_query($conn, $sql_enable_fk)) {
        echo "<p class='text-center text-green-600'>Habitación eliminada correctamente.</p>";
    } else {
        echo "<p class='text-center text-red-600'>Error al eliminar la habitación: " . mysqli_error($conn) . "</p>";
    }
}

// Búsqueda de habitaciones
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT room_id, room_number, room_floor, room_state, description, room_price FROM 068_rooms WHERE room_number LIKE '%$search%'";
} else {
    $sql = "SELECT room_id, room_number, room_floor, room_state, description, room_price FROM 068_rooms";
}
$result = mysqli_query($conn, $sql);

// Incluir el encabezado de la página
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
?>

<!-- Contenedor principal -->
<section class="reserva my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Eliminar Habitación</h2>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="" class="mb-10 text-center">
        <input type="text" name="search" placeholder="Buscar por Número de Habitación" value="<?php echo htmlspecialchars($search); ?>" class="border p-2 rounded-lg">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Buscar</button>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                <div class='bg-white p-6 rounded-lg shadow-lg text-center'>
                    <h3 class='text-2xl font-semibold text-blue-800 mb-4'>Número de Habitación: " . htmlspecialchars($row['room_number']) . "</h3>
                    <p class='text-lg text-gray-700 mb-2'><strong>Piso:</strong> " . htmlspecialchars($row['room_floor']) . "</p>
                    <p class='text-lg text-gray-700 mb-2'><strong>Estado:</strong> " . htmlspecialchars($row['room_state']) . "</p>
                    <p class='text-lg text-gray-700 mb-2'><strong>Descripción:</strong> " . htmlspecialchars($row['description']) . "</p>
                    <p class='text-lg text-gray-700 mb-4'><strong>Precio:</strong> $" . htmlspecialchars($row['room_price']) . "</p>
                    <form action='' method='POST' onsubmit='return confirmarEliminacion();'>
                        <input type='hidden' name='room_number' value='" . htmlspecialchars($row['room_number']) . "'>
                        <button type='submit' name='delete_room' class='w-full bg-red-500 text-white p-3 rounded-lg hover:bg-red-600 transition-colors'>Eliminar Habitación</button>
                    </form>
                </div>";
            }
        } else {
            echo "<p class='text-center text-xl text-gray-700'>No se encontraron habitaciones.</p>";
        }
        ?>
    </div>
</section>

<script>
    function confirmarEliminacion() {
        return confirm("Estás a punto de eliminar una habitación. ¿Estás seguro?");
    }
</script>

<?php
mysqli_close($conn);
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>
