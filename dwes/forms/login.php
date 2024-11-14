    <?php
    // Conectar a la base de datos
    include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');

    // Inicializar variables
    $username = $password = $error_message = "";

    // Función para manejar el proceso de inicio de sesión
    function Iniciarlogin($conn) {
        global $username, $password, $error_message, $userrole;

        // Verificar si el formulario fue enviado
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            
            // Primero buscamos en la tabla 068_users
            $sql = "SELECT * FROM 068_customers WHERE username = '$username' LIMIT 1"; 
            $result = mysqli_query($conn, $sql);

            // Si el usuario no se encuentra en 068_users, buscamos en 068_employee
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                // Verificamos la contraseña en texto claro
                if ($password === $row['password']) {
                    session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['userrole'] = "customer";
                    header("Location: ../index.php"); 
                    exit();
                } else {
                    $error_message = "Contraseña incorrecta.";
                }
            } else {
                // Si no se encontró en 068_users, buscar en 068_employee
                $sql_employee = "SELECT * FROM 068_employee WHERE username = '$username' LIMIT 1";
                $result_employee = mysqli_query($conn, $sql_employee);

                if (mysqli_num_rows($result_employee) > 0) {
                    $row = mysqli_fetch_assoc($result_employee);
                    // Verificamos la contraseña en texto claro
                    if ($password === $row['password']) {
                        session_start();
                        $_SESSION['username'] = $username;
                        if($row['role'] === "admin") {
                            $_SESSION['userrole'] = "admin";
                        } else {
                            $_SESSION['userrole'] = "employee";
                        }
                        header("Location: ../index.php"); 
                        exit();
                    } else {
                        $error_message = "Contraseña incorrecta.";
                    }
                } else {
                    // Si no se encontró el usuario en ninguna de las dos tablas
                    $error_message = "Usuario no encontrado.";
                }
            }
        }
    }

    // Llamar a la función para manejar el inicio de sesión
    Iniciarlogin($conn);

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
    ?>

    <?php
    include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
    ?>

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full">
            <h2 class="text-3xl font-playfair font-semibold text-center mb-6 text-blue-900">Iniciar Sesión</h2>
            
            <form action="./login.php" method="post" class="space-y-6">
                <div>
                    <label for="username" class="block text-lg text-blue-800">Nombre de Usuario:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
                </div>
                <div>
                    <label for="password" class="block text-lg text-blue-800">Contraseña:</label>
                    <input type="password" id="password" name="password" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
                </div>
                <button type="submit" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Iniciar Sesión</button>
            </form>

            <?php if (!empty($error_message)): ?>
                <div class="text-red-600 text-center mb-4">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <p>¿No tienes cuenta? <a href="./register.php" class="font-bold	focus:border-blue-400"> ¡Registrate ahora!</a></p>
        </div>
    </div>

    <?php
    // Incluye el pie de página
    include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
    ?>
