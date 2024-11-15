<?php
include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/.gitignore/database/remoteconnection.php');
?>
<?php
// Verificar conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Consulta para obtener todas los clientes
$sql = "SELECT customer_name, customer_last_name, customer_dni, customer_address, phone_number, customer_birthdate FROM 068_customers";
$result = mysqli_query($conn, $sql);

// Incluir el encabezado de la página
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
?>

<!-- Contenedor principal centrado -->
<div class="container mx-auto my-16 px-6">
    <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Todos los clientes</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        <?php
        // Mostrar resultados si hay reservas en la base de datos
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                <div class='bg-white p-6 rounded-lg shadow-lg text-center'>
                    <h3 class='text-2xl font-semibold text-blue-800 mb-4'>Nombre: " . htmlspecialchars($row['customer_name'] ." ". $row['customer_last_name']) . "</h3>
                    <p class='text-lg text-gray-700 mb-2'><strong>DNI:</strong> " . htmlspecialchars($row['customer_dni']) . "</p>
                    <p class='text-lg text-gray-700 mb-2'><strong>Dirección</strong> " . htmlspecialchars($row['customer_address']) . "</p>
                    <p class='text-lg text-gray-700 mb-2'><strong>Número de teléfono:</strong> " . htmlspecialchars($row['phone_number']) . "</p>
                    <p class='text-lg text-gray-700 mb-4'><strong>Fecha de nacimiento:</strong> " . htmlspecialchars($row['customer_birthdate']) . "</p>
                </div>
                ";
            }
        } else {
            echo "<p class='text-center text-xl text-gray-700'>No hay clientes en este momento.</p>";
        }
        ?>

    </div>
</div>

<!-- $rows = mysqli_fetch_all($result, MYSQLI_ASSOC); 

foreach($rows as $row){
    echo $row['customer_name'] . " " . $row['customer_last_name'] . "<br>";
    echo $row['customer_dni'] . "<br>";
    echo $row['customer_address'] . "<br>";
    echo $row['phone_number'] . "<br>";
} -->

<?php
// Cerrar la conexión
mysqli_close($conn);

// Incluir el pie de página
include($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>
