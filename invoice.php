<?php 
    include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');
    include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
    include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');

    $customer_id = $_POST['customer_id'];

    $sql = "SELECT * FROM 068_reservations
            INNER JOIN 068_customers
            ON 068_reservations.customer_id = 068_customers.customer_id
            INNER JOIN 068_rooms
            ON 068_reservations.room_id = 068_rooms.room_id
            WHERE 068_reservations.customer_id = '$customer_id'";
    
    $result = mysqli_query($conn, $sql);

    if($row = mysqli_fetch_assoc($result)) {
        $extra = json_decode($row['extra']);

    } else {
        echo "<p class='text-center text-xl text-gray-700'>No hay reservas para este cliente.</p>";
    }