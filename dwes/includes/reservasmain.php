<?php 
//             include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/forms/customers_reservation/customer_reservation.php');


if (isset($_COOKIE['reservation_number']) && isset($_COOKIE['last_name']) && 
        !empty($_COOKIE['reservation_number']) && !empty($_COOKIE['last_name'])) {
            
            $reservation_number = $_COOKIE['reservation_number'];
            $last_name = $_COOKIE['last_name'];

            include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/forms/customers_reservation/customer_reservation_cookie.php');
    }else{
?>

<div class="container mx-auto py-12">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Consultar Reserva</h1>

    <form action="../forms/customers_reservation/customer_reservation.php" method="POST" class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
        <!-- Número de Reserva -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2" for="reservation_number">Número de Reserva</label>
            <input type="text" name="reservation_number" id="reservation_number" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
                   placeholder="Introduce tu número de reserva" required>
        </div>

        <!-- Apellido -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2" for="last_name">Apellido</label>
            <input type="text" name="last_name" id="last_name" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
                   placeholder="Introduce tu apellido" required>
        </div>

        <!-- Botón de Enviar -->
        <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-500">
            Consultar Reserva
        </button>
    </form>
</div>

<?php
    }
    ?>
