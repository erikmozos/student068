<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la Actualización</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body>
<section class="my-16 px-6">
    <div class="max-w-lg mx-auto p-8 bg-white shadow-lg rounded-lg text-center">
        <?php
        if (isset($_GET['status']) && isset($_GET['message'])) {
            $status = htmlspecialchars($_GET['status']);
            $message = htmlspecialchars($_GET['message']);

            if ($status == 'success') {
                echo "<h2 class='text-2xl font-semibold text-green-600'>Éxito</h2>";
            } else {
                echo "<h2 class='text-2xl font-semibold text-red-600'>Error</h2>";
            }
            echo "<p class='mt-4'>$message</p>";
        }
        ?>
        <a href="reservations.php" class="mt-6 inline-block bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Volver al Menú de Gestión de Reservas</a>
    </div>
</section>
</body>
</html>
