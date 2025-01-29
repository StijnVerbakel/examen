<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Selection</title>
    
</head>
<body>

</body>
</html>

<?php 
echo '<button onclick="window.location.href=\'index.php\'">Index</button>';
include_once('Oop.php');
session_start();

 if ($_SESSION["rol"] === "directie" || $_SESSION["rol"] === "chauffeur") 
 {
    $table = new Table("planning",false, true); // table read only / can sea
}
 else 
 {
 //$table2 = new Table("planning",true, false); // table read only / can sea
 }
var_dump($_SESSION["rol"]);

?>

<!-- 
Document Name: planning.php
Made by: sem van Haaften
-->

