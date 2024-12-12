<?php

include ($_SERVER['DOCUMENT_ROOT'].'/student068/dwes/functions/functions.php');

session_start();
session_unset(); 
session_destroy(); 

destroy_all_cookies();

header("Location: /student068/dwes/index.php"); 
?>
