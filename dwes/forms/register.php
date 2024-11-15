<?php
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');

$error_message = "";

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapar y sanitizar los datos recibidos para evitar inyecciones SQL
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellido']);
    $dni = $conn->real_escape_string($_POST['dni']);
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $email = $conn->real_escape_string($_POST['email']);
    $fecha_nacimiento = $conn->real_escape_string($_POST['fecha_nacimiento']);
    $username = mysqli_escape_string($conn,$_POST['username']);
    $password = $_POST['password']; 

    function esMayorDeEdad($fecha_nacimiento) {
        // Crear un objeto DateTime con la fecha de nacimiento
        $fecha_nacimiento_obj = new DateTime($fecha_nacimiento);
        
        // Obtener la fecha actual
        $fecha_actual = new DateTime();
    
        // Calcular la diferencia de años entre la fecha de nacimiento y la fecha actual
        $edad = $fecha_actual->diff($fecha_nacimiento_obj)->y;
    
        // Verificar si la edad es 18 o más
        return $edad >= 18;
    }

    if (esMayorDeEdad($fecha_nacimiento) === false) {
        $error_message = "Debes tener al menos 18 años para registrarte.";
    } else {
        // Insertar datos en la tabla si la edad es suficiente
        $sql = "INSERT INTO 068_customers (customer_name, customer_last_name, customer_dni, customer_address, phone_number, customer_email, customer_birthdate, password, username) 
                VALUES ('$nombre', '$apellido', '$dni', '$direccion', '$telefono', '$email', '$fecha_nacimiento', '$password', '$username')";

        if ($conn->query($sql) === TRUE) {
            echo "<p class='text-center text-green-600 font-semibold'>¡Registro exitoso!</p>";
        } else {
            echo "<p class='text-center text-red-600 font-semibold'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }

        // Cerrar la conexión
        $conn->close();
    }
}
?>

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-3xl font-playfair font-semibold text-center mb-6 text-blue-900">Registrarse</h2>

        <?php if ($error_message): ?>
            <p class="text-center text-red-600 font-semibold mb-4"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form action="register.php" method="post" class="space-y-6">
            <div>
                <label for="nombre" class="block text-lg text-blue-800">Nombre:</label>
                <input type="text" name="nombre" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
            </div>
            
            <div>
                <label for="apellido" class="block text-lg text-blue-800">Apellido:</label>
                <input type="text" name="apellido" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
            </div>
            
            <div>
                <label for="dni" class="block text-lg text-blue-800">DNI:</label>
                <input type="text" name="dni" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
            </div>
            
            <div>
                <label for="direccion" class="block text-lg text-blue-800">Dirección:</label>
                <input type="text" name="direccion" class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
            </div>
            
            <div>
                <label for="telefono" class="block text-lg text-blue-800">Teléfono:</label>
                <input type="text" name="telefono" class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
            </div>
            
            <div>
                <label for="email" class="block text-lg text-blue-800">Correo Electrónico:</label>
                <input type="email" name="email" class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
            </div>
            
            <div>
                <label for="fecha_nacimiento" class="block text-lg text-blue-800">Fecha de Nacimiento:</label>
                <input type="date" name="fecha_nacimiento" class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
            </div>
            
            <div>
                <label for="username" class="block text-lg text-blue-800">Nombre de Usuario:</label>
                <input type="text" name="username" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
            </div>
            
            <div>
                <label for="password" class="block text-lg text-blue-800">Contraseña:</label>
                <input type="password" name="password" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
            </div>

            <button type="submit" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Registrar</button>
        </form>

        <p class="mt-4 text-center">¿Ya tienes una cuenta? <a href="./login.php" class="font-bold text-blue-800 hover:text-blue-900">Inicia sesión aquí</a></p>
    </div>
</div>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>
