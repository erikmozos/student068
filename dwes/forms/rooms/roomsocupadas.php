<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";

// Crear conexión
$conn = new mysqli($servername, $username, $password, 'hotel');

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Consulta para obtener habitaciones ocupadas
$sql = "SELECT room_number, room_price, description, room_state FROM rooms WHERE room_state = 'ocupada'";
$result = mysqli_query($conn, $sql);

// Incluir el encabezado de la página
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
?>

<!-- Contenedor principal centrado -->
<div class="container mx-auto my-16 px-6 min-h-screen">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Habitaciones Ocupadas</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        <?php
        // Mostrar resultados si hay habitaciones ocupadas
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                <div class='bg-white p-6 rounded-lg shadow-lg text-center'>
                    <h3 class='text-2xl font-semibold text-blue-800 mb-4'>Habitación: " . $row['room_number'] . "</h3>
                    <p class='text-lg text-gray-700 mb-2'><strong>Precio:</strong> $" . $row['room_price'] . "</p>
                    <p class='text-gray-600 mb-4'><strong>Descripción:</strong> " . $row['description'] . "</p>
                    <p class='text-red-600 font-bold'><strong>Estado:</strong> Ocupada</p>
                </div>
                ";
            }
        } else {
            echo "<p class='text-center text-xl text-gray-700'>No hay habitaciones ocupadas en este momento.</p>";
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
