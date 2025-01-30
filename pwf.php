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
    <script>
        function validateForm(event) {
            let password = document.getElementById("password").value;
            let confirmPassword = document.getElementById("confirm_password").value;
            let errorMessage = document.getElementById("error_message");
            
            if (password !== confirmPassword) {
                errorMessage.textContent = "Passwords do not match!";
                event.preventDefault();
            } else {
                errorMessage.textContent = "";
            }
        }
    </script>
</head>
<body>
    <form onsubmit="validateForm(event)">
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