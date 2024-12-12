<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');

if ($_SESSION['userrole'] !== "admin" && $_SESSION['userrole'] !== "employee") {
    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: /student068/dwes/index.php");
    exit();
}

// Consulta para obtener habitaciones disponibles
$sql = "SELECT room_number, room_price, description, room_state FROM 068_rooms WHERE room_state = 'disponible'";
$result = mysqli_query($conn, $sql);

// Incluir el encabezado de la página
?>

<!-- Contenedor principal centrado -->
<div class="container mx-auto my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Habitaciones Disponibles</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        <?php
        // Mostrar resultados si hay habitaciones disponibles
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                <div class='bg-white p-6 rounded-lg shadow-lg text-center'>
                    <h3 class='text-2xl font-semibold text-blue-800 mb-4'>Habitación: " . $row['room_number'] . "</h3>
                    <p class='text-lg text-gray-700 mb-2'><strong>Precio:</strong> $" . $row['room_price'] . "</p>
                    <p class='text-gray-600 mb-4'><strong>Descripción:</strong> " . $row['description'] . "</p>
                    <p class='text-green-600 font-bold'><strong>Estado:</strong> Disponible</p>
                </div>
                ";
            }
        } else {
            echo "<p class='text-center text-xl text-gray-700'>No hay habitaciones disponibles en este momento.</p>";
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
