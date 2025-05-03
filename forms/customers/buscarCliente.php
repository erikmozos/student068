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
$customer_name = "";
$customer_last_name = "";
$customer_dni = "";
$customer_address = "";
$phone_number = "";
$customer_birthdate = "";

// Obtener datos del cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['customer_dni'])) {
        $customer_dni = $_POST['customer_dni'];

        // Consulta para obtener la información del cliente
        $sql = "SELECT * FROM customers WHERE customer_dni = '$customer_dni'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $customer_name = $row['customer_name'];
            $customer_last_name = $row['customer_last_name'];
            $customer_address = $row['customer_address'];
            $phone_number = $row['phone_number'];
            $customer_birthdate = $row['customer_birthdate'];
        } else {
            echo "<p class='text-center text-red-600'>No se encontró el cliente con DNI $customer_dni.</p>";
        }
    }

    // Actualizar los datos del cliente si se ha enviado un formulario de actualización
    if (isset($_POST['update'])) {
        $customer_name = $_POST['customer_name'];
        $customer_last_name = $_POST['customer_last_name'];
        $customer_address = $_POST['customer_address'];
        $phone_number = $_POST['phone_number'];
        $customer_birthdate = $_POST['customer_birthdate'];

        // Consulta para actualizar la información del cliente
        $update_sql = "UPDATE customers SET 
                        customer_name='$customer_name', 
                        customer_last_name='$customer_last_name', 
                        customer_dni='$customer_dni', 
                        customer_address='$customer_address', 
                        phone_number='$phone_number', 
                        customer_birthdate='$customer_birthdate' 
                        WHERE customer_dni='$customer_dni'";

        if (mysqli_query($conn, $update_sql)) {
            header("Location: resultado.php?status=success&message=Cliente actualizado correctamente.");
            exit();
        } else {
            header("Location: resultado.php?status=error&message=Error al actualizar el cliente: " . mysqli_error($conn));
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
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body>
<section class="cliente my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Editar Información del Cliente</h2>
    <form action="buscarCliente.php" method="POST" class="max-w-lg mx-auto p-8 bg-white shadow-lg rounded-lg space-y-6">
        <input type="hidden" name="customer_dni" value="<?php echo htmlspecialchars($customer_dni); ?>">
        
        <div>
            <label for="customer_dni" class="block text-lg text-blue-800">ID del Cliente</label>
            <input type="text" id="customer_dni" name="customer_dni" value="<?php echo htmlspecialchars($customer_dni); ?>" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500" readonly>
        </div>
        
        <div>
            <label for="customer_name" class="block text-lg text-blue-800">Nombre</label>
            <input type="text" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($customer_name); ?>" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        
        <div>
            <label for="customer_last_name" class="block text-lg text-blue-800">Apellidos</label>
            <input type="text" id="customer_last_name" name="customer_last_name" value="<?php echo htmlspecialchars($customer_last_name); ?>" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        
        <div>
            <label for="customer_address" class="block text-lg text-blue-800">Dirección</label>
            <input type="text" id="customer_address" name="customer_address" value="<?php echo htmlspecialchars($customer_address); ?>" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        
        <div>
            <label for="phone_number" class="block text-lg text-blue-800">Número de Teléfono</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        
        <div>
            <label for="customer_birthdate" class="block text-lg text-blue-800">Fecha de Nacimiento</label>
            <input type="date" id="customer_birthdate" name="customer_birthdate" value="<?php echo htmlspecialchars($customer_birthdate); ?>" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        
        <button type="submit" name="update" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Actualizar Cliente</button>
    </form>
</section>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>
