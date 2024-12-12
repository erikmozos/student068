    <?php

    function destroy_all_cookies() {
        // Verificar si hay cookies
        if (isset($_SERVER['HTTP_COOKIE'])) {
            // Separar todas las cookies en un array
            $cookies = explode('; ', $_SERVER['HTTP_COOKIE']);
            
            foreach ($cookies as $cookie) {
                // Separar el nombre y valor de la cookie
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);

                // Evitar eliminar la cookie de la sesión
                if ($name != 'PHPSESSID') {
                    // Configurar cada cookie con tiempo de expiración pasado y el mismo path
                    setcookie($name, '', time() - 3600, '/');  // Para todas las cookies con path '/'
                    setcookie($name, '', time() - 3600);       // En caso de que algunas cookies tengan un path diferente
                }
            }
        }
    }



    function handleImageUpload($conn, $room_number, $file) {
        // Ruta de destino para las imágenes
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/student068/dwes/uploads/';

        // Verificar si la carpeta existe, si no crearla
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Obtener la extensión del archivo
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Validar extensión
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            return [
                'success' => false,
                'message' => 'Formato de archivo no permitido. Solo se permiten JPG, JPEG, PNG y GIF.'
            ];
        }

        // Renombrar el archivo con base en el número de habitación
        $newFileName = 'room_' . $room_number . '.' . $fileExtension;
        $destination = $uploadDir . $newFileName;

        // Eliminar la imagen anterior si existe
        $query = "SELECT image_url FROM 068_room_types WHERE room_type_id = (SELECT room_type_id FROM 068_rooms WHERE room_number = '$room_number')";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . '/student068/dwes/' . $row['image_url'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Mover el archivo cargado a la carpeta de destino
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            // Guardar la nueva ruta en la base de datos
            $relativePath = 'uploads/' . $newFileName;
            $updateQuery = "UPDATE 068_room_types SET image_url = '$relativePath' WHERE room_type_id = (SELECT room_type_id FROM 068_rooms WHERE room_number = '$room_number')";

            if (mysqli_query($conn, $updateQuery)) {
                return [
                    'success' => true,
                    'message' => 'La imagen fue subida y actualizada con éxito.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al actualizar la ruta de la imagen en la base de datos: ' . mysqli_error($conn)
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Error al mover el archivo cargado.'
            ];
        }
    }


    ?>