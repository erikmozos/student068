
<?php
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
?>


<section class="adminpage my-16 px-6 space-y-6 max-w-lg mx-auto ">


    <form action="<?php echo '/student068/dwes/forms/rooms/rooms.php'; ?>">
    <button type="submit" class="w-full bg-gray-600 text-white p-3 rounded-lg hover:bg-gray-700 transition-colors">Gestionar Habitaciones</button>
    </form>
    <form action="<?php echo '/student068/dwes/forms/reservations/reservations.php'; ?>">
    <button type="submit" class="w-full bg-blue-400 text-white p-3 rounded-lg hover:bg-blue-700 transition-colors">Gestionar Reservas</button>
    </form>
    <form action="<?php echo '/student068/dwes/forms/customers/customers.php'; ?>">
    <button type="submit" class="w-full bg-green-400 text-white p-3 rounded-lg hover:bg-green-700 transition-colors ">Gestionar Clientes</button>
    </form>


</section>



<?php

include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>