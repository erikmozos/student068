<?php
    include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');
    include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');

    if ($_SESSION['userrole'] !== "admin" && $_SESSION['userrole'] !== "employee") {
        header("Location: /student068/dwes/index.php");
        exit();
    }

    $reservation_number = "";
    $date_in = "";
    $date_out = "";
    $today = date("Y-m-d"); // Fecha actual

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['reservation_number'])) {
            $reservation_number = $_POST['reservation_number'];

            // Verificar si es Check-in
            if (isset($_POST['check_in'])) {
                $check_in_sql = "UPDATE 068_reservations SET status='checked_in' WHERE reservation_number='$reservation_number'";
                mysqli_query($conn, $check_in_sql);
            }

            // Verificar si es Check-out
            if (isset($_POST['check_out'])) {
                $check_out_sql = "UPDATE 068_reservations SET status='checked_out' WHERE reservation_number='$reservation_number'";
                mysqli_query($conn, $check_out_sql);
            }
        }
    }

    // Obtener las reservas del día
    $sql_today = "SELECT * FROM 068_reservations WHERE date_in <= '$today' AND date_out >= '$today'";
    $result_today = mysqli_query($conn, $sql_today);

    if (mysqli_num_rows($result_today) > 0) {
        echo "<div class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6'>"; // Grid de 3 columnas

        while ($row = mysqli_fetch_assoc($result_today)) {
            $reservation_number = $row['reservation_number'];
            $date_in = $row['date_in'];
            $date_out = $row['date_out'];
            $status = $row['status'];
            $room_id = $row['room_id'];

            // Obtener el nombre o número de la habitación utilizando el room_id
            $room_query = "SELECT room_number FROM 068_rooms WHERE room_id = '$room_id'";
            $room_result = mysqli_query($conn, $room_query);
            $room = mysqli_fetch_assoc($room_result);
            $room_number = $room['room_number']; // Asumiendo que 'room_number' es el nombre de la habitación

            // Obtener las reservas que solapan en fechas con la nueva reserva
            $check_room_sql = "
                SELECT r.room_id, r.status
                FROM 068_reservations r
                WHERE r.room_id = '$room_id' 
                AND r.status != 'checked_out'
                AND (
                    (r.date_in <= '$today' AND r.date_out >= '$today')
                )";
            $check_room_result = mysqli_query($conn, $check_room_sql);

            // Imprimir las cards de las reservas
            echo "<div class='reservation-card bg-white p-4 shadow-md rounded-lg'>";
            echo "<p class='font-semibold text-lg text-blue-700'>Reserva #: $reservation_number</p>";
            echo "<p>Habitación: $room_number</p>"; // Mostrar la habitación correspondiente
            echo "<p>Fecha de entrada: $date_in</p>";
            echo "<p>Fecha de salida: $date_out</p>";

            // Check-in button
            if ($date_in == $today && $status != 'checked_in' && $status != 'checked_out') {
                // Verificar si la habitación ya está ocupada
                if (mysqli_num_rows($check_room_result) > 0) {
                    echo "<p class='text-red-600'>La habitación $room_number ya está ocupada. No puede hacer check-in hasta que la habitación esté disponible.</p>";
                } else {
                    // Si no hay ninguna reserva ocupando la habitación, permitir check-in
                    echo "<form method='POST'>
                            <input type='hidden' name='reservation_number' value='$reservation_number'>
                            <button type='submit' name='check_in' class='mt-2 w-full py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600'>Check-in</button>
                          </form>";
                }
            }

            // Check-out button
            if ($date_out == $today && $status != 'checked_out') {
                echo "<form method='POST'>
                        <input type='hidden' name='reservation_number' value='$reservation_number'>
                        <button type='submit' name='check_out' class='mt-2 w-full py-2 bg-green-500 text-white rounded-md hover:bg-green-600'>Check-out</button>
                      </form>";
            }

            echo "</div>"; // Fin de la card
        }

        echo "</div>"; // Cierre del grid
    } else {
        echo "<p class='text-center text-red-600'>No hay reservas para hoy.</p>";
    }
?>
