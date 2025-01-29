<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Selection</title>
    
</head>
<body>
    <div class="form-container">
        <h2>Select a Table</h2>
        <form action="./crud.php" method="POST">
            <div class="form-group">
                <input type="radio" id="artikelen" name="table" value="artikelen" required>
                <label for="artikelen">Artikelen</label>
            </div>
            <div class="form-group">
                <input type="radio" id="personeel" name="table" value="personeel">
                <label for="personeel">Personeel</label>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>

<?php 
echo '<button onclick="window.location.href=\'index.php\'">Index</button>';
include_once('Oop.php');


$table = new Table();

?>

<!-- 
Document Name: crud.php
Made by: Stijn Verbakel
-->

