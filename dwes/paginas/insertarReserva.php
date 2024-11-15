<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');

// Verificar si los datos necesarios están presentes
if (isset($_POST['room_id'], $_POST['check-in'], $_POST['check-out'], $_POST['guests'], $_POST['customer_name'], $_POST['customer_last_name'], $_POST['customer_dni'], $_POST['customer_address'], $_POST['phone_number'], $_POST['customer_email'], $_POST['customer_birthdate'])) {
    
    // Obtener los datos del formulario
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check-in'];
    $check_out = $_POST['check-out'];
    $guests = (int) $_POST['guests'];
    
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $customer_last_name = mysqli_real_escape_string($conn, $_POST['customer_last_name']);
    $customer_dni = mysqli_real_escape_string($conn, $_POST['customer_dni']);
    $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
    $customer_birthdate = mysqli_real_escape_string($conn, $_POST['customer_birthdate']);

    // Verificar si el usuario está autenticado
    if (isset($_SESSION['user_id'])) {
        $customer_id = $_SESSION['user_id']; // Usar el ID del usuario logueado
    } else {
        // Si no está autenticado, crear un cliente nuevo (o redirigir a login)
        // Para simplicidad, asumimos que se crea un nuevo cliente en este caso
        $sql_insert_customer = "INSERT INTO 068_customers (customer_name, customer_last_name, customer_dni, customer_address, phone_number, customer_email, customer_birthdate)
                                VALUES ('$customer_name', '$customer_last_name', '$customer_dni', '$customer_address', '$phone_number', '$customer_email', '$customer_birthdate')";
        if (mysqli_query($conn, $sql_insert_customer)) {
            $customer_id = mysqli_insert_id($conn); // Obtener el ID del nuevo cliente
        } else {
            echo "Error al crear el cliente: " . mysqli_error($conn);
            exit();
        }
    }

    // Generar un número de reserva único (podrías personalizar esto según tus necesidades)
    $reservation_number = rand(1000000000, 9999999999); // Número de reserva aleatorio

    // Calcular el precio total de la reserva
    $sql_price = "SELECT price_per_night FROM 068_room_type_view2 WHERE room_id = '$room_id'";
    $result = mysqli_query($conn, $sql_price);
    $room = mysqli_fetch_assoc($result);
    $price_per_night = $room['price_per_night'];
    $reservation_price = $price_per_night * $guests; // Total de la reserva

    // Insertar la reserva en la base de datos
    $sql_insert_reservation = "INSERT INTO 068_reservations (customer_id, room_id, reservation_number, date_in, date_out, number_of_customers, reservation_price, extras)
                               VALUES ('$customer_id', '$room_id', '$reservation_number', '$check_in', '$check_out', '$guests', '$reservation_price', '{}')";
    
    if (mysqli_query($conn, $sql_insert_reservation)) {
        echo "Reserva realizada con éxito. Número de reserva: " . $reservation_number;
    } else {
        echo "Error al realizar la reserva: " . mysqli_error($conn);
    }
} else {
    echo "Faltan datos para completar la reserva.";
}
?>
