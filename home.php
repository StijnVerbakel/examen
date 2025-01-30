<?php
include_once('Oop.php');
session_start();
var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu in Div</title> 
</head>
<body>
    <header class="menu">
        <h1>Kringloop Centrum</h1>
        <a href="home.php">Home</a>

        <!-- Dropdown menu voor ritten -->
        <div class="dropdown">
            <button class="dropbtn">Ritten</button>
            <div class="dropdown-content">
                <a href="planning.php">Ritten planning</a>
            </div>
        </div>

        <!-- Dropdown menu voor admin -->
         <div class="dropdown">
            <button class="dropbtn">Admin</button>
            <div class="dropdown-content">
                <a href="planning.php">Ritten planning</a>
                <a href="magazijn.php">Voorraadbeheer</a>
                <a href="artikelen.php">Artikelen</a>
                <a href="Klant.php">Klanten</a>
            </div>
         </div>
    </header> 
    <div class="grid-container">
        <?php
        if ( $_SESSION["rol"] === "magazijn" ) 
        {
            echo'
    <a href="artikelen.php"><div class="grid-item"> 
            <h3>Ritten</h3>
            <p>beschrijving</p>
            <button>Ga naar ritten</button>
        </div></a>';

        }elseif ( $_SESSION["rol"] === "directie" )  {

        }elseif ( $_SESSION["rol"] === "winkelpersoneel" )  {

        }elseif ( $_SESSION["rol"] === "chauffeur" )  {

        }else {

        }
?>
</body>
</html>


<!-- 
Document Name: home.php
Made by: Anouk Grandia, Lauro El-Bagdadi, Stijn Verbakel en Sem van Haaften
-->