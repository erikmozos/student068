<?php
    include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');
    include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');

    if ($_SESSION['userrole'] !== "admin" && $_SESSION['userrole'] !== "employee") {
        header("Location: /student068/dwes/index.php");
        exit();
    }

    $today = date("Y-m-d"); // Fecha actual

    // Verificar si es un formulario POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Filtrar las entradas para evitar inyecciones SQL
        $reservation_number = mysqli_real_escape_string($conn, $_POST['reservation_number']);

        // Verificar si es Check-in
        if (isset($_POST['check_in'])) {
            $check_in_sql = "UPDATE 068_reservations SET status='checked_in' WHERE reservation_number=?";
            $stmt = mysqli_prepare($conn, $check_in_sql);
            mysqli_stmt_bind_param($stmt, "s", $reservation_number);
            mysqli_stmt_execute($stmt);
        }

        // Verificar si es Check-out
        if (isset($_POST['check_out'])) {
            $check_out_sql = "UPDATE 068_reservations SET status='checked_out' WHERE reservation_number=?";
            $stmt = mysqli_prepare($conn, $check_out_sql);
            mysqli_stmt_bind_param($stmt, "s", $reservation_number);
            mysqli_stmt_execute($stmt);
        }
    }

    // Obtener las reservas pendientes de Check-in
    $sql_check_in = "SELECT * FROM 068_reservations WHERE date_in = '$today' AND status != 'checked_in' AND status != 'checked_out'";
    $result_check_in = mysqli_query($conn, $sql_check_in);

    // Obtener las reservas pendientes de Check-out
    $sql_check_out = "SELECT * FROM 068_reservations WHERE date_out = '$today' AND status != 'checked_out'";
    $result_check_out = mysqli_query($conn, $sql_check_out);

    echo "<div class='flex justify-between gap-6'>"; // Usamos flexbox para poner dos columnas

    // Mostrar las reservas para Check-in
    echo "<div class='w-1/2'>";
    echo "<h2 class='font-semibold text-lg text-blue-700 mb-4'>Pendientes de Check-in</h2>";

    if (mysqli_num_rows($result_check_in) > 0) {
        while ($row = mysqli_fetch_assoc($result_check_in)) {
            $reservation_number = $row['reservation_number'];
            $date_in = $row['date_in'];
            $date_out = $row['date_out'];
            $status = $row['status'];
            $room_id = $row['room_id'];

            // Obtener el número de habitación
            $room_query = "SELECT room_number FROM 068_rooms WHERE room_id = ?";
            $stmt_room = mysqli_prepare($conn, $room_query);
            mysqli_stmt_bind_param($stmt_room, "i", $room_id);
            mysqli_stmt_execute($stmt_room);
            $room_result = mysqli_stmt_get_result($stmt_room);
            $room = mysqli_fetch_assoc($room_result);
            $room_number = $room['room_number'];

            // Mostrar la tarjeta de la reserva
            echo "<div class='reservation-card bg-white p-4 shadow-md rounded-lg mb-4'>";
            echo "<p class='font-semibold text-lg text-blue-700'>Reserva #: $reservation_number</p>";
            echo "<p>Habitación: $room_number</p>";
            echo "<p>Fecha de entrada: $date_in</p>";
            echo "<p>Fecha de salida: $date_out</p>";

            // Botón de Check-in
            if ($status != 'checked_in') {
                // Comprobar si la habitación está ocupada en el día de hoy
                $check_room_sql = "
                    SELECT * 
                    FROM 068_reservations 
                    WHERE room_id = '$room_id' 
                    AND status != 'checked_out' 
                    AND (date_in <= '$today' AND date_out >= '$today')
                ";
        
                // Preparamos y ejecutamos la consulta
                $resultado = mysqli_query($conn, $check_room_sql);
        
                // Verificar si la habitación está ocupada
                if (mysqli_num_rows($resultado) > 1) {
                    // Si hay alguna reserva en este día, la habitación está ocupada
                    echo "<p class='text-red-600'>La habitación $room_number ya está ocupada. No puede hacer check-in hasta que la habitación esté disponible.</p>";
                } else {
                    // Si la habitación está libre, permitir check-in
                    echo "<form method='POST'>
                            <input type='hidden' name='reservation_number' value='$reservation_number'>
                            <button type='submit' name='check_in' class='mt-2 w-full py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600'>Check-in</button>
                          </form>";
                }
            }

            echo "</div>";
        }
    } else {
        echo "<p>No hay reservas pendientes de check-in.</p>";
    }
    echo "</div>"; // Fin de la columna para Check-in

    // Mostrar las reservas para Check-out
    echo "<div class='w-1/2'>";
    echo "<h2 class='font-semibold text-lg text-green-700 mb-4'>Pendientes de Check-out</h2>";

    if (mysqli_num_rows($result_check_out) > 0) {
        while ($row = mysqli_fetch_assoc($result_check_out)) {
            $reservation_number = $row['reservation_number'];
            $date_in = $row['date_in'];
            $date_out = $row['date_out'];
            $status = $row['status'];
            $room_id = $row['room_id'];

            // Obtener el número de habitación
            $room_query = "SELECT room_number FROM 068_rooms WHERE room_id = ?";
            $stmt_room = mysqli_prepare($conn, $room_query);
            mysqli_stmt_bind_param($stmt_room, "i", $room_id);
            mysqli_stmt_execute($stmt_room);
            $room_result = mysqli_stmt_get_result($stmt_room);
            $room = mysqli_fetch_assoc($room_result);
            $room_number = $room['room_number'];

            // Mostrar la tarjeta de la reserva
            echo "<div class='reservation-card bg-white p-4 shadow-md rounded-lg mb-4'>";
            echo "<p class='font-semibold text-lg text-green-700'>Reserva #: $reservation_number</p>";
            echo "<p>Habitación: $room_number</p>";
            echo "<p>Fecha de entrada: $date_in</p>";
            echo "<p>Fecha de salida: $date_out</p>";

            // Botón de Check-out
            if ($status != 'checked_out') {
                echo "<form method='POST'>
                        <input type='hidden' name='reservation_number' value='$reservation_number'>
                        <button type='submit' name='check_out' class='mt-2 w-full py-2 bg-green-500 text-white rounded-md hover:bg-green-600'>Check-out</button>
                      </form>";
            }

            echo "</div>";
        }
    } else {
        echo "<p>No hay reservas pendientes de check-out.</p>";
    }
    echo "</div>"; // Fin de la columna para Check-out

    echo "</div>"; // Fin del flexbox
?>
