<?php
include_once('Oop.php');
echo '<button onclick="window.location.href=\'Login.php\'">Go to Inlog</button>';
echo '<button onclick="window.location.href=\'./klant.php\'">Klant overzicht</button>';

$table = "klant";
$table2 = new Table("klant",false,true);
?>