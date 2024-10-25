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

// Eliminar reserva
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_reservation'])) {
    $reservation_id = $_POST['reservation_id'];

    // Consulta para eliminar la reserva
    $sql_delete_reservation = "DELETE FROM 068_reservations WHERE reservation_id = '$reservation_id'";
    if (mysqli_query($conn, $sql_delete_reservation)) {
        echo "<p class='text-center text-green-600'>Reserva eliminada correctamente.</p>";
    } else {
        echo "<p class='text-center text-red-600'>Error al eliminar la reserva: " . mysqli_error($conn) . "</p>";
    }
}

// Búsqueda de reservas
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // Cambiar el campo de búsqueda a reservation_number
    $sql = "SELECT reservation_id, date_in, date_out, number_of_customers, reservation_number, reservation_price FROM 068_reservations WHERE reservation_number LIKE '%" . $conn->real_escape_string($search) . "%'";
} else {
    $sql = "SELECT reservation_id, date_in, date_out, number_of_customers, reservation_number, reservation_price FROM 068_reservations";
}
$result = mysqli_query($conn, $sql);

// Incluir el encabezado de la página
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
?>

<!-- Contenedor principal centrado -->
<div class="container mx-auto my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Todas las Reservas</h2>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="" class="mb-10 text-center">
        <input type="text" name="search" placeholder="Buscar por Número de Reserva" value="<?php echo htmlspecialchars($search); ?>" class="border p-2 rounded-lg">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Buscar</button>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                <div class='bg-white p-6 rounded-lg shadow-lg text-center'>
                    <h3 class='text-2xl font-semibold text-blue-800 mb-4'>Número de Reserva: " . htmlspecialchars($row['reservation_number']) . "</h3>
                    <p class='text-lg text-gray-700 mb-2'><strong>Fecha de Entrada:</strong> " . htmlspecialchars($row['date_in']) . "</p>
                    <p class='text-lg text-gray-700 mb-2'><strong>Fecha de Salida:</strong> " . htmlspecialchars($row['date_out']) . "</p>
                    <p class='text-lg text-gray-700 mb-2'><strong>Número de Clientes:</strong> " . htmlspecialchars($row['number_of_customers']) . "</p>
                    <p class='text-lg text-gray-700 mb-4'><strong>Precio de la Reserva:</strong> $" . htmlspecialchars($row['reservation_price']) . "</p>
                    <form action='' method='POST' onsubmit='return confirmarEliminacion();'>
                        <input type='hidden' name='reservation_id' value='" . htmlspecialchars($row['reservation_id']) . "'>
                        <button type='submit' name='delete_reservation' class='w-full bg-red-500 text-white p-3 rounded-lg hover:bg-red-600 transition-colors'>Eliminar Reserva</button>
                    </form>
                </div>";
            }
        } else {
            echo "<p class='text-center text-xl text-gray-700'>No se encontraron reservas.</p>";
        }
        ?>
    </div>
</div>

<script>
    function confirmarEliminacion() {
        return confirm("Estás a punto de eliminar una reserva. ¿Estás seguro?");
    }
</script>

<?php
mysqli_close($conn);
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>
