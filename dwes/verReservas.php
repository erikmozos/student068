<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "hotel"; // Base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Inicializar variables
$reservation_number = "";
$date_in = "";
$date_out = "";
$number_of_customers = "";
$reservation_price = "";
$extras = "";

// Obtener datos de la habitación
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['reservation_number'])) {
        $reservation_number = $_POST['reservation_number'];

        // Consulta para obtener la información de la reserva
        $sql = "SELECT * FROM reservations WHERE reservation_number = '$reservation_number'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $date_in = $row['date_in'];
            $date_out = $row['date_out'];
            $number_of_customers = $row['number_of_customers'];
            $reservation_price = $row['reservation_price'];
            $extras = $row['extras'];
        } else {
            echo "<p class='text-center text-red-600'>No se encontró la reserva con número $reservation_number.</p>";
        }
    }

    // Actualizar la reserva si se ha enviado un formulario de actualización
    if (isset($_POST['update'])) {
        $date_in = $_POST['date_in'];
        $date_out = $_POST['date_out'];
        $number_of_customers = $_POST['number_of_customers'];
        $reservation_price = $_POST['reservation_price'];
        $extras = $_POST['extras'];

        // Consulta para actualizar la información de la reserva
        $update_sql = "UPDATE reservations SET date_in='$date_in', date_out='$date_out', number_of_customers='$number_of_customers', reservation_price='$reservation_price', extras='$extras' WHERE reservation_number='$reservation_number'";

        if (mysqli_query($conn, $update_sql)) {
            header("Location: resultado.php?status=success&message=Reserva actualizada correctamente.");
            exit();
        } else {
            header("Location: resultado.php?status=error&message=Error al actualizar la reserva: " . mysqli_error($conn));
            exit();
        }
    }
}

mysqli_close($conn);
?>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body>
<section class="reserva my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Editar Información de la Reserva</h2>
    <form action="verReservas.php" method="POST" class="max-w-lg mx-auto p-8 bg-white shadow-lg rounded-lg space-y-6">
        <input type="hidden" name="reservation_number" value="<?php echo htmlspecialchars($reservation_number); ?>">
        
        <div>
            <label for="reservation_number" class="block text-lg text-blue-800">Número de Reserva</label>
            <input type="text" id="reservation_number" name="reservation_number" value="<?php echo htmlspecialchars($reservation_number); ?>" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500" readonly>
        </div>
        
        <div>
            <label for="date_in" class="block text-lg text-blue-800">Fecha de Entrada</label>
            <input type="date" id="date_in" name="date_in" value="<?php echo htmlspecialchars($date_in); ?>" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        
        <div>
            <label for="date_out" class="block text-lg text-blue-800">Fecha de Salida</label>
            <input type="date" id="date_out" name="date_out" value="<?php echo htmlspecialchars($date_out); ?>" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        
        <div>
            <label for="number_of_customers" class="block text-lg text-blue-800">Número de Clientes</label>
            <input type="number" id="number_of_customers" name="number_of_customers" value="<?php echo htmlspecialchars($number_of_customers); ?>" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        
        <div>
            <label for="reservation_price" class="block text-lg text-blue-800">Precio de la Reserva</label>
            <input type="number" id="reservation_price" name="reservation_price" value="<?php echo htmlspecialchars($reservation_price); ?>" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        
        <div>
            <label for="extras" class="block text-lg text-blue-800">Extras</label>
            <textarea id="extras" name="extras" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500"><?php echo htmlspecialchars($extras); ?></textarea>
        </div>
        
        <button type="submit" name="update" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Actualizar Reserva</button>
    </form>
</section>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>
