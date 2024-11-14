<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');

// Recibir los datos del formulario
$reservation_number = $_POST['reservation_number'];
$last_name = $_POST['last_name'];

// Consulta SQL para obtener la información de la reserva uniendo 'reservations' y 'customers'
$sql = "SELECT reservations.reservation_number, reservations.date_in, reservations.date_out, 
               reservations.room_id, reservations.number_of_customers, reservations.reservation_price, reservations.extras, 
               customers.customer_name, customers.customer_last_name
        FROM 068_reservations AS reservations
        JOIN 068_customers AS customers ON reservations.customer_id = customers.customer_id
        WHERE reservations.reservation_number = '$reservation_number' AND customers.customer_last_name = '$last_name'";

$result = mysqli_query($conn, $sql);

include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php'); 
?>

<div class="container mx-auto py-12">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Información de la Reserva</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php $reservation = mysqli_fetch_assoc($result); ?>
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
            <p><strong>Número de Reserva:</strong> <?php echo $reservation['reservation_number']; ?></p>
            <p><strong>Nombre Completo:</strong> <?php echo $reservation['customer_name'] . " " . $reservation['customer_last_name']; ?></p>
            <p><strong>Fecha de Entrada:</strong> <?php echo $reservation['date_in']; ?></p>
            <p><strong>Fecha de Salida:</strong> <?php echo $reservation['date_out']; ?></p>
            <p><strong>Número de Clientes:</strong> <?php echo $reservation['number_of_customers']; ?></p>
            <p><strong>Precio Total:</strong> <?php echo "$" . $reservation['reservation_price']; ?></p>
            <p><strong>Extras:</strong> <?php echo $reservation['extras'] ? $reservation['extras'] : 'Ninguno'; ?></p>
        </div>
    <?php else: ?>
        <p class="text-center text-red-600">No se encontró ninguna reserva con el número y apellido proporcionados.</p>
    <?php endif; ?>

</div>

<?php
// Cerrar conexión
mysqli_close($conn);
?>
