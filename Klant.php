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
echo '<button onclick="window.location.href=\'home.php\'">Home</button>';
include_once('Oop.php');
session_start();

 if ($_SESSION["rol"] === "directie"|| $_SESSION["rol"] === "winkelpersoneel") 
 {
    $table = new Table("klant",false, true); // table read only / can see
}
 else 
 {
 $table2 = new Table("klant",true, cansee: false); // table read only / can see
 }


?>

<!-- 
Document Name: Klant.php
Made by: Sem van Haaften
>>>>>>> f55da59f73d526302d11c12a9a91da736758ad82
-->