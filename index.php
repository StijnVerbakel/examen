<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Gebruikersnaam" class="input-field" required>
            <input type="password" name="password" placeholder="Wachtwoord" class="input-field" required>
            <button type="submit" class="btn">Inloggen</button>
            <?php 
                echo '<button onclick="window.location.href=\'./registreren.php\'">Registreren</button>'; 
                echo '<button onclick="window.location.href=\'./pwf.php\'">Wachtwoord vergeten?</button>';
            ?>
        </form>
    </div>  
</body>
</html>
<?php
include_once('Oop.php');
$login = new login();
?>

<!-- 
Document Name: Index.php
Made by: Anouk Grandia, Lauro El-Bagdadi, Stijn Verbakel en Sem van Haaften
-->