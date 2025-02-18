<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulier</title>
</head>
<body>
    <form action="" method="post">
        <!-- Rol -->
        <label for="Rol">Rol:</label>
        <select id="Rol" name="Rol" required>
            <option value="">-- Selecteer een rol --</option>
            <option value="directie">directie</option>
            <option value="magazijn">magazijn</option>
            <option value="winkelpersoneel">winkelpersoneel</option>
            <option value="chauffeur">chauffeur</option>
            
        </select>
        <br><br> 

        <!-- Gebruikersnaam -->
        <label for="gebruikersnaam">Gebruikersnaam:</label>
        <input type="text" id="gebruikersnaam" name="gebruikersnaam" required>
        <br><br>

        <!-- Wachtwoord -->
        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" id="wachtwoord" name="wachtwoord" required>
        <br><br>

        <!-- Adres -->
        <label for="Adres">Adres:</label>
        <textarea id="Adres" name="Adres" rows="4" cols="30" required></textarea>
        <br><br>

        <!-- Verzenden -->
        <button type="submit">Verzenden</button>   
    </form>
   
</body>
</html>


<?php
include_once('Oop.php');
// Database connection (Oop.php)
$database = new Database();
$conn = $database->conn;    
$registreren = new registreren();
?>

<!-- 
Document Name: registreren.php
Made by: Anouk Grandia, Lauro El-Bagdadi, Stijn Verbakel en Sem van Haaften
-->