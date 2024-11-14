<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');

$check_in = $_POST['check-in'];
$check_out = $_POST['check-out'];
$personas = (int)$_POST['guests'];

if($check_in < date("Y-m-d") || $check_out < date("Y-m-d") || $check_out < $check_in) {
    header("Location: /student068/dwes/index.php");
    exit();
}


$sql = "SELECT DISTINCT type_name, price_per_night, description, capacity
        FROM 068_room_type_view
        WHERE room_id NOT IN (
            SELECT room_id
            FROM 068_reservations
            WHERE date_in < '$check_out' AND date_out > '$check_in'
        )
        AND capacity >= $personas
        GROUP BY type_name";

$result = mysqli_query($conn, $sql);

include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php'); 
?>

<div class="container mx-auto my-16 px-6 min-h-screen">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Categorías disponibles</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                    <div class='bg-white p-6 rounded-lg shadow-lg text-center'>
                        <p class='text-lg text-gray-700 mb-2'><strong>Tipo:</strong> " . $row['type_name'] . "</p>
                        <p class='text-lg text-gray-700 mb-2'><strong>Capacidad:</strong> " . $row['capacity'] . " personas</p>
                        <p class='text-lg text-gray-700 mb-2'><strong>Precio:</strong> $" . $row['price_per_night'] . "</p>
                        <p class='text-gray-600 mb-4'><strong>Descripción:</strong> " . $row['description'] . "</p>
                        <button class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>
                            <a href='detalles.php?tipo=" . urlencode($row['type_name']) . "'>Más info</a>
                        </button>
                    </div>
                ";
            }
        } else {
            echo "
            <div class='bg-white p-6 rounded-lg shadow-lg text-center'>
            <p class='text-center text-gray-700'>No hay categorías disponibles para las fechas y capacidad seleccionadas.</p>
            </div>";
        }
        ?>
    </div>
</div>
