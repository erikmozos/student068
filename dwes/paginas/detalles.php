<?php
  // Iniciar la sesión para poder verificar si el usuario está autenticado
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');


if(isset($_COOKIE['room'])){
    $room_id = $_COOKIE['room'];
}else{
    $room_id = $_GET['room_id'];
}

// Verificar si se pasa un room_id
if (isset($room_id)) {

    
    setcookie('room', $room_id, time() + 300, '/');

    // Obtener detalles de la habitación específica
    $sql = "SELECT room_id, type_name, price_per_night, description, capacity, image_url
            FROM 068_room_type_view2
            WHERE room_id = '$room_id'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $room_details = mysqli_fetch_assoc($result);
    } else {
        echo "No se encontraron detalles para esta habitación.";
        exit();
    }
} else {
    echo "No se proporcionó un ID de habitación válido.";
    exit();
}

?>

<div class="container mx-auto my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900"><?php echo $room_details['type_name']; ?></h2>
    <div class="flex justify-center">
        <div class="max-w-2xl">
            <?php $img = $room_details['image_url']; ?>
            <img src="<?php echo $img; ?>" alt="Imagen de la habitación" class="w-full h-96 object-cover mb-6">
            
            <p class="text-lg text-gray-700 mb-4"><strong>Capacidad:</strong> <?php echo $room_details['capacity']; ?> personas</p>
            <p class="text-lg text-gray-700 mb-4"><strong>Precio por noche:</strong> $<?php echo $room_details['price_per_night']; ?></p>
            <p class="text-gray-600 mb-6"><strong>Descripción:</strong> <?php echo $room_details['description']; ?></p>
            
            <!-- Formulario de reserva -->
            <!-- <?php //if (isset($_SESSION['username'])): ?> -->
                <!-- Si la sesión está iniciada, redirigir al pago -->
                <!-- <form action="pago.php" method="post">
                    <input type="hidden" name="room_id" value="<?php //  echo $room_details['room_id']; ?>">
                    <input type="hidden" name="check-in" value="<?php // echo $check_in; ?>">
                    <input type="hidden" name="check-out" value="<?php //echo $check_out; ?>">
                    <input type="hidden" name="guests" value="<?php //echo $personas; ?>">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Pagar
                    </button> -->
            <!-- <?php //else: ?> -->
                <!-- Si la sesión no está iniciada, redirigir al formulario de reserva -->
                <form action="<?php if(isset($_SESSION['username'])){
                    echo './formulario_reserva.php';
                }else{
                    echo '../forms/login.php';
                } ?>" method="post">
                    <input type="hidden" name="room_id" value="<?php echo $room_details['room_id']; ?>">
                    <input type="hidden" name="check-in" value="<?php echo $check_in; ?>">
                    <input type="hidden" name="check-out" value="<?php echo $check_out; ?>">
                    <input type="hidden" name="guests" value="<?php echo $personas; ?>">
                    <input type="hidden" name="username" value="">
                    <input type="hidden" name="password" value="">

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Completar reserva
                    </button>
                </form>
            <!-- <?php // endif; ?> -->
        </div>
    </div>
</div>
