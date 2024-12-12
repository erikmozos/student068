<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');

$message = "";




// Verificar si se enviaron datos del formulario de selección de extras
if (!empty($_COOKIE['reservation_number']) && !empty($_COOKIE['last_name'])) {

    $reservation_number = $_COOKIE['reservation_number'];
    $selected_extras = $_POST['extras'] ?? []; // Obtener los extras seleccionados
    $current_date = date('Y-m-d H:i:s'); // Fecha actual para los extras

    // Obtener los datos actuales de extras_json
    $sql = "SELECT extras_json FROM 068_reservations WHERE reservation_number = '$reservation_number'";
    $result = mysqli_query($conn, $sql);
    $current_data = mysqli_fetch_assoc($result)['extras_json'];
    $current_extras = $current_data ? json_decode($current_data, true) : ["services" => []];

    // Inicializar servicios si están vacíos
    if (!isset($current_extras["services"][0]["restaurant"])) {
        $current_extras["services"][0]["restaurant"] = [];
    }
    if (!isset($current_extras["services"][1]["wellnessCenter"])) {
        $current_extras["services"][1]["wellnessCenter"] = [];
    }

    // Organizar los nuevos extras en las categorías correspondientes
    foreach ($selected_extras as $extra) {
        if ($extra === 'Late Check-out') {
            $current_extras["services"][1]["wellnessCenter"][] = [
                "ticketNumber" => rand(1000, 9999),
                "date" => $current_date,
                "products" => [
                    [
                        "productName" => "Late Check-out",
                        "quantity" => 1,
                        "unitPrice" => 20.0
                    ]
                ]
            ];
        } elseif ($extra === 'Desayuno') {
            $current_extras["services"][0]["restaurant"][] = [
                "ticketNumber" => rand(1000, 9999),
                "date" => $current_date,
                "products" => [
                    [
                        "productName" => "Desayuno",
                        "quantity" => 1,
                        "unitPrice" => 15.0
                    ]
                ]
            ];
        } elseif ($extra === 'Acceso al Spa') {
            $current_extras["services"][1]["wellnessCenter"][] = [
                "ticketNumber" => rand(1000, 9999),
                "date" => $current_date,
                "products" => [
                    [
                        "productName" => "Acceso al Spa",
                        "quantity" => 1,
                        "unitPrice" => 45.0
                    ]
                ]
            ];
        } elseif ($extra === 'Transporte al Aeropuerto') {
            $current_extras["services"][1]["wellnessCenter"][] = [
                "ticketNumber" => rand(1000, 9999),
                "date" => $current_date,
                "products" => [
                    [
                        "productName" => "Transporte al Aeropuerto",
                        "quantity" => 1,
                        "unitPrice" => 30.0
                    ]
                ]
            ];
        }
    }

    // Convertir a JSON
    $updated_extras_json = json_encode($current_extras, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    

    // Actualizar la columna extras_json en la tabla reservations
    $update_sql = "UPDATE 068_reservations SET extras_json = '$updated_extras_json' WHERE reservation_number = '$reservation_number'";
    if (mysqli_query($conn, $update_sql)) {
        $message = "<p class='text-green-600 text-center'>Extras actualizados correctamente.</p>";
    } else {
        $message = "<p class='text-red-600 text-center'>Error al actualizar los extras: " . mysqli_error($conn) . "</p>";
    }
}

// Recibir los datos del formulario inicial
$reservation_number = $_COOKIE['reservation_number'] ?? '';
$last_name = $_COOKIE['last_name'] ?? '';

// Consulta SQL para obtener la información de la reserva
$sql = "SELECT reservations.reservation_number, reservations.date_in, reservations.date_out, 
               reservations.room_id, reservations.number_of_customers, reservations.reservation_price, reservations.extras_json, 
               customers.customer_name, customers.customer_last_name
        FROM 068_reservations AS reservations
        JOIN 068_customers AS customers ON reservations.customer_id = customers.customer_id
        WHERE reservations.reservation_number = '$reservation_number' AND customers.customer_last_name = '$last_name'";

$result = mysqli_query($conn, $sql);

// include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php'); 
?>

<div class="container mx-auto py-12">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Información de la Reserva</h1>

    <?php  // Mostrar mensaje si existe ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php $reservation = mysqli_fetch_assoc($result); ?>
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
            <p><strong>Número de Reserva:</strong> <?php echo $reservation['reservation_number']; ?></p>
            <p><strong>Nombre Completo:</strong> <?php echo $reservation['customer_name'] . " " . $reservation['customer_last_name']; ?></p>
            <p><strong>Fecha de Entrada:</strong> <?php echo $reservation['date_in']; ?></p>
            <p><strong>Fecha de Salida:</strong> <?php echo $reservation['date_out']; ?></p>
            <p><strong>Número de Clientes:</strong> <?php echo $reservation['number_of_customers']; ?></p>
            <p><strong>Precio Total:</strong> <?php echo "$" . $reservation['reservation_price']; ?></p>
            <p><strong>Extras:</strong></p>
            <ul>
                <?php
                if (!empty($reservation['extras_json'])) {
                    $extras = json_decode($reservation['extras_json'], true);
                    $summary = [];

                    // Procesar los extras para contar por categoría
                    foreach ($extras["services"] as $category) {
                        foreach ($category as $type => $entries) {
                            foreach ($entries as $entry) {
                                foreach ($entry["products"] as $product) {
                                    $name = $product["productName"];
                                    $quantity = $product["quantity"];
                                    if (!isset($summary[$name])) {
                                        $summary[$name] = 0;
                                    }
                                    $summary[$name] += $quantity;
                                }
                            }
                        }
                    }

                    // Mostrar el resumen
                    foreach ($summary as $name => $quantity) {
                        echo "<li class='text-gray-700'>" . htmlspecialchars($name) . " [" . htmlspecialchars($quantity) . "]</li>";
                    }
                } else {
                    echo "<li class='text-gray-500'>Ninguno</li>";
                }
                ?>
            </ul>
        </div>

        <!-- Formulario para seleccionar extras -->
        <form method="POST" class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Seleccionar Extras</h2>
            <input type="hidden" name="reservation_number" value="<?php echo $reservation['reservation_number']; ?>">

            <div class="grid grid-cols-2 gap-4">
                <!-- Card 1 -->
                <div class="border rounded-lg p-4 bg-gray-100">
                    <h3 class="font-bold text-lg">Late Check-out</h3>
                    <p class="text-sm text-gray-600">Permite quedarte hasta las 14:00.</p>
                    <p class="text-blue-500 font-semibold">Precio: $20</p>
                    <label class="flex items-center space-x-2 mt-2">
                        <input type="checkbox" name="extras[]" value="Late Check-out">
                        <span>Seleccionar</span>
                    </label>
                </div>

                <!-- Card 2 -->
                <div class="border rounded-lg p-4 bg-gray-100">
                    <h3 class="font-bold text-lg">Desayuno</h3>
                    <p class="text-sm text-gray-600">Desayuno buffet disponible de 7:00 a 10:00.</p>
                    <p class="text-blue-500 font-semibold">Precio: $15</p>
                    <label class="flex items-center space-x-2 mt-2">
                        <input type="checkbox" name="extras[]" value="Desayuno">
                        <span>Seleccionar</span>
                    </label>
                </div>

                <!-- Card 3 -->
                <div class="border rounded-lg p-4 bg-gray-100">
                    <h3 class="font-bold text-lg">Acceso al Spa</h3>
                    <p class="text-sm text-gray-600">Disfruta de sauna y piscina climatizada.</p>
                    <p class="text-blue-500 font-semibold">Precio: $45</p>
                    <label class="flex items-center space-x-2 mt-2">
                        <input type="checkbox" name="extras[]" value="Acceso al Spa">
                        <span>Seleccionar</span>
                    </label>
                </div>

                <!-- Card 4 -->
                <div class="border rounded-lg p-4 bg-gray-100">
                    <h3 class="font-bold text-lg">Transporte al Aeropuerto</h3>
                    <p class="text-sm text-gray-600">Servicio de traslado ida o vuelta.</p>
                    <p class="text-blue-500 font-semibold">Precio: $30</p>
                    <label class="flex items-center space-x-2 mt-2">
                        <input type="checkbox" name="extras[]" value="Transporte al Aeropuerto">
                        <span>Seleccionar</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 mt-4 w-full">Guardar Extras</button>
        </form>
        
        <button></button>
        
        <?php endif; ?>
</div>
