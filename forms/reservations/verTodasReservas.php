<?php
// Configuración de conexión a la base de datos
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

// Consulta para obtener todas las reservas
$sql = "SELECT reservation_number, date_in, date_out, number_of_customers, reservation_price, extras FROM reservations";
$result = mysqli_query($conn, $sql);

// Incluir el encabezado de la página
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
?>

<!-- Contenedor principal centrado -->
<div class="container mx-auto my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Todas las Reservas</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        <?php
        // Mostrar resultados si hay reservas en la base de datos
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                <div class='bg-white p-6 rounded-lg shadow-lg text-center'>
                    <h3 class='text-2xl font-semibold text-blue-800 mb-4'>Número de Reserva: " . htmlspecialchars($row['reservation_number']) . "</h3>
                    <p class='text-lg text-gray-700 mb-2'><strong>Fecha de Entrada:</strong> " . htmlspecialchars($row['date_in']) . "</p>
                    <p class='text-lg text-gray-700 mb-2'><strong>Fecha de Salida:</strong> " . htmlspecialchars($row['date_out']) . "</p>
                    <p class='text-lg text-gray-700 mb-2'><strong>Número de Clientes:</strong> " . htmlspecialchars($row['number_of_customers']) . "</p>
                    <p class='text-lg text-gray-700 mb-4'><strong>Precio de la Reserva:</strong> $" . htmlspecialchars($row['reservation_price']) . "</p>
                    <p class='text-gray-600 mb-4'><strong>Extras:</strong> " . htmlspecialchars($row['extras']) . "</p>
                </div>
                ";
            }
        } else {
            echo "<p class='text-center text-xl text-gray-700'>No hay reservas registradas en este momento.</p>";
        }
        ?>

    </div>
</div>

<?php
// Cerrar la conexión
mysqli_close($conn);

// Incluir el pie de página
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>
