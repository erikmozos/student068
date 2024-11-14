<?php
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php'); // Agregué el punto y coma al final
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');

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
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

    // Insertar datos en la tabla
    $sql = "INSERT INTO tu_tabla_de_clientes (customer_name, customer_last_name, customer_dni, customer_address, phone_number, customer_email, customer_birthdate, password, username) 
            VALUES ('$nombre', '$apellido', '$dni', '$direccion', '$telefono', '$email', '$fecha_nacimiento', '$password', '$username')";

    // Ejecutar la consulta e informar al usuario
    if ($conn->query($sql) === TRUE) {
        echo "<p>Registro exitoso!</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
</head>
<body>
    <h2>Formulario de Registro</h2>
    <form action="registro.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" required><br>

        <label for="dni">DNI:</label>
        <input type="text" name="dni" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion"><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono"><br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email"><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento"><br>

        <label for="username">Nombre de Usuario:</label>
        <input type="text" name="username" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>
