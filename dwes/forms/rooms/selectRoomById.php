<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');

if ($_SESSION['userrole'] !== "admin" && $_SESSION['userrole'] !== "employee") {
    header("Location: /student068/dwes/index.php");
    exit();
}

$room_number = "";
$room_price = "";
$description = "";
$room_state = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['room_price'])) {
        $room_number = $_POST['room_number'];
        $room_price = $_POST['room_price'];
        $description = $_POST['description'];
        $room_state = $_POST['room_state'];

        // Actualizar información de la habitación
        $update_sql = "UPDATE 068_rooms SET room_price = '$room_price', description = '$description', room_state = '$room_state' WHERE room_number = '$room_number'";
        
        if (mysqli_query($conn, $update_sql)) {
            // Manejar la imagen cargada
            if (isset($_FILES['room_img']) && $_FILES['room_img']['error'] == UPLOAD_ERR_OK) {
                $uploadResult = handleImageUpload($conn, $room_number, $_FILES['room_img']);
                echo "<p class='text-center text-green-600'>{$uploadResult['message']}</p>";
            } else {
                echo "<p class='text-center text-yellow-600'>No se subió ninguna imagen o hubo un problema con la carga.</p>";
            }
        } else {
            echo "<p class='text-center text-red-600'>Error al actualizar la habitación: " . mysqli_error($conn) . "</p>";
        }
    } else {
        $room_number = $_POST['room_number'];
        $sql = "SELECT * FROM 068_rooms WHERE room_number = '$room_number'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $room_price = $row['room_price'];
            $description = $row['description'];
            $room_state = $row['room_state'];
            $room_type = $row['room_type_id'];
        } else {
            echo "<p class='text-center text-red-600'>No se encontró la habitación con número $room_number.</p>";
        }
    }
}

mysqli_close($conn);

function handleImageUpload($conn, $room_number, $file) {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/student068/dwes/paginas/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
        return ['success' => false, 'message' => 'Formato de archivo no permitido.'];
    }

    $newFileName = 'room_' . $room_number . '.' . $fileExtension;
    $destination = $uploadDir . $newFileName;

    $query = "SELECT image_url FROM 068_room_types WHERE room_type_id = (SELECT room_type_id FROM 068_rooms WHERE room_number = '$room_number')";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . '/student068/dwes/paginas/uploads' . $row['image_url'];
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
    }

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $relativePath = 'uploads/' . $newFileName;
        $updateQuery = "UPDATE 068_room_types SET image_url = '$relativePath' WHERE room_type_id = (SELECT room_type_id FROM 068_rooms WHERE room_number = '$room_number')";
        if (mysqli_query($conn, $updateQuery)) {
            return ['success' => true, 'message' => 'Imagen actualizada con éxito.'];
        } else {
            return ['success' => false, 'message' => 'Error al guardar la ruta de la imagen: ' . mysqli_error($conn)];
        }
    } else {
        return ['success' => false, 'message' => 'Error al mover el archivo cargado.'];
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Habitación</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body>
<section class="reserva my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Editar Información de la Habitación</h2>
    <form method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto p-8 bg-white shadow-lg rounded-lg space-y-6">
    <input type="hidden" name="room_number" value="<?php echo $room_number; ?>">
        <div>
            <label for="room_price" class="block text-lg text-blue-800">Precio de la Habitación</label>
            <input type="number" id="room_price" name="room_price" value="<?php echo $room_price; ?>" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <div>
            <label for="description" class="block text-lg text-blue-800">Descripción</label>
            <textarea id="description" name="description" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500"><?php echo $description; ?></textarea>
        </div>
        <div>
            <label for="room_state" class="block text-lg text-blue-800">Estado</label>
            <select id="room_state" name="room_state" class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
                <option value="disponible" <?php if ($room_state == 'disponible') echo 'selected'; ?>>Disponible</option>
                <option value="ocupada" <?php if ($room_state == 'ocupada') echo 'selected'; ?>>Ocupada</option>
                <option value="mantenimiento" <?php if ($room_state == 'mantenimiento') echo 'selected'; ?>>Mantenimiento</option>
            </select>
        </div>
        <div>
            <label for="room_img" class="block text-lg text-blue-800">Cambiar imagen</label>
            <input type="file" id="room_img" name="room_img" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>
        <button type="submit" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Actualizar Habitación</button>
    </form>
</section>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>
