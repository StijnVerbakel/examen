<?php
include_once('Oop.php');
$pwf = new pwf();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>

</head>
<body>
    <form method="post" action="pwf.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <br>
        <p id="error_message"></p>  
        <button type="submit">Wachtwoord aanpassen</button>
        <?php echo '<button onclick="window.location.href=\'index.php\'">Terug naar inloggen</button>'; ?>
    </form>
    
</body>
</html>

<!-- 
Document Name: pwf.php
Made by: Anouk Grandia, Lauro El-Bagdadi, Stijn Verbakel en Sem van Haaften
-->