<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "hotel";  // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Eliminar cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_customer'])) {
    $customer_dni = $_POST['customer_dni'];

    // Consulta para eliminar el cliente por su DNI
    $sql_delete_customer = "DELETE FROM customers WHERE customer_dni = '$customer_dni'";

    if (mysqli_query($conn, $sql_delete_customer)) {
        echo "<p class='text-center text-green-600'>Cliente eliminado correctamente.</p>";
    } else {
        echo "<p class='text-center text-red-600'>Error al eliminar el cliente: " . mysqli_error($conn) . "</p>";
    }
}

// Filtrar clientes por DNI
$filter_dni = isset($_POST['filter_dni']) ? $_POST['filter_dni'] : '';
$sql = "SELECT customer_dni, customer_name, customer_last_name, customer_address, phone_number, customer_birthdate FROM customers";
if (!empty($filter_dni)) {
    $sql .= " WHERE customer_dni LIKE '%" . $conn->real_escape_string($filter_dni) . "%'";
}

$result = mysqli_query($conn, $sql);

// Incluir el encabezado de la página
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Cliente</title>
</head>
<body>

<section class="reserva my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Eliminar Cliente</h2>

    <!-- Formulario de búsqueda -->
    <form method="POST" class="mb-6 text-center">
        <input type="text" name="filter_dni" value="<?php echo htmlspecialchars($filter_dni); ?>" placeholder="Buscar por DNI" class="p-2 border rounded">
        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Buscar</button>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                <div class='bg-white p-6 rounded-lg shadow-lg text-center'>
                    <h3 class='text-2xl font-semibold text-blue-800 mb-4'>Nombre: " . htmlspecialchars($row['customer_name'] ." ". $row['customer_last_name']) . "</h3>
                    <p class='text-lg text-gray-700 mb-2'><strong>DNI:</strong> " . htmlspecialchars($row['customer_dni']) . "</p>
                    <p class='text-lg text-gray-700 mb-2'><strong>Dirección:</strong> " . htmlspecialchars($row['customer_address']) . "</p>
                    <p class='text-lg text-gray-700 mb-2'><strong>Número de Teléfono:</strong> " . htmlspecialchars($row['phone_number']) . "</p>
                    <p class='text-lg text-gray-700 mb-4'><strong>Fecha de Nacimiento:</strong> " . htmlspecialchars($row['customer_birthdate']) . "</p>

                    <!-- Formulario para eliminar cliente -->
                    <form action='' method='POST' onsubmit='return confirmarEliminacion();'>
                        <input type='hidden' name='customer_dni' value='" . htmlspecialchars($row['customer_dni']) . "'>
                        <button type='submit' name='delete_customer' class='w-full bg-red-500 text-white p-3 rounded-lg hover:bg-red-600 transition-colors'>Eliminar Cliente</button>
                    </form>
                </div>
                ";
            }
        } else {
            echo "<p class='text-center text-xl text-gray-700'>No hay clientes registrados en este momento.</p>";
        }
        ?>

    </div>
</section>

<script>
    function confirmarEliminacion() {
        return confirm("Estás a punto de eliminar un cliente. ¿Estás seguro?");
    }
</script>

<?php
// Cerrar la conexión
mysqli_close($conn);

// Incluir el pie de página
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>
