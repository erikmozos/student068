<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');

// Recibir los datos del formulario
$reservation_number = $_POST['reservation_number'];
$extras = isset($_POST['extras']) ? implode(", ", $_POST['extras']) : null;

// Actualizar los extras en la tabla reservations
$sql = "UPDATE 068_reservations 
        SET extras = '$extras' 
        WHERE reservation_number = '$reservation_number'";

if (mysqli_query($conn, $sql)) {
    echo "<p class='text-center text-green-600'>Los extras se han actualizado correctamente.</p>";
} else {
    echo "<p class='text-center text-red-600'>Error al actualizar los extras: " . mysqli_error($conn) . "</p>";
}

// Cerrar conexión
mysqli_close($conn);

// Redireccionar a la página principal
header("Location: customer_reservation.php");
exit;
?>
