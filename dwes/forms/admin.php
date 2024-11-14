
<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php'); // Incluye el encabezado

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: /student068/dwes/forms/login.php");
    exit();
}
?>


<section class="adminpage my-16 px-6 space-y-6 max-w-lg mx-auto ">


    <form action="<?php echo '/student068/dwes/forms/rooms/roomsOptions.php'; ?>">
    <button type="submit" class="w-full bg-gray-600 text-white p-3 rounded-lg hover:bg-gray-700 transition-colors">Gestionar Habitaciones</button>
    </form>
    <form action="<?php echo '/student068/dwes/forms/reservations/reservationsOptions.php'; ?>">
    <button type="submit" class="w-full bg-blue-400 text-white p-3 rounded-lg hover:bg-blue-700 transition-colors">Gestionar Reservas</button>
    </form>
    <form action="<?php echo '/student068/dwes/forms/customers/customersOptions.php'; ?>">
    <button type="submit" class="w-full bg-green-400 text-white p-3 rounded-lg hover:bg-green-700 transition-colors ">Gestionar Clientes</button>
    </form>
    <?php if ($_SESSION['userrole'] === "admin"): ?>
    <form action="<?php echo '/student068/dwes/forms/customers/customersOptions.php'; ?>">
    <button type="submit" class="w-full bg-green-400 text-white p-3 rounded-lg hover:bg-green-700 transition-colors ">Gestionar Empleados</button>
    </form>
    <?php endif; ?>

</section>



<?php

include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>