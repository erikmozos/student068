
<?php
    include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/header.php');
    include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/maininicio.php');
    include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/includes/footer.php');
?>





<?php
$calles = array("Calle Miguel de Cervantes 12", "calle Aña huh");

for ($i = 0; $i < count($calles); $i++) {
    $calles[$i] = ucwords(strtolower($calles[$i]));
}

print_r($calles);
?>
