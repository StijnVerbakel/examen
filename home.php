<?php
include_once('Oop.php');
session_start();
var_dump($_SESSION)
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu in Div</title>
    <style> 
        /* Algemene stijl voor de pagina */
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        /* Menu container */
        .menu {
            display: flex;
            align-items: center;
            background-color: #007BFF; /* Blauwe achtergrond */
            padding: 15px 20px;
        }

        /* Titelstijl */
        .menu h1 {
            color: white;
            margin: 0;
            font-size: 28px;
        }

        /* Stijl voor de links in het menu */
        .menu a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        /* Hover effect voor de links */
        .menu a:hover {
            text-decoration: underline;
            color: #ffd700; /* Gele kleur bij hover */
        }

        /* Dropdown container */
        .dropdown {
            position: relative;
            display: inline-block;
            margin-left: 20px;
        }

        /* Dropdown knop stijl */
        .dropbtn {
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Dropdown knop hover effect */

        /* De dropdown-content (die standaard verborgen is) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #343a40; /* Donkere achtergrond voor de dropdown */
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
        }

        /* Links in de dropdown */
        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 16px;
        }

        /* Verander de kleur van de links bij hover in de dropdown */
        .dropdown-content a:hover {
            background-color: #007BFF; /* Blauwe kleur bij hover */
        }

        /* Toon de dropdown-content als je met de muis over de dropdown heen beweegt */
        .dropdown:hover .dropdown-content {
            display: block;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(2,400px);
            grid-template-rows: repeat(2,200px);
            gap: 20px;
            justify-content: center;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
            margin-top: 5%;            
        }

        .grid-item {
            justify-content: center;
            width: 80%;
            height: 80%;
            padding: 10px;
            background-color: white;
            color: black;
            text-align: center;
            text-decoration: none;
            border: 1px black solid;
            border-radius: 10px;
            transition: background-color 0.3s, transform 0.2s;
        }   
        
        .grid-item:hover {
            cursor: pointer;
            background-color: grey;
            transform: scale(1.05);
        }

    </style>   
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
i
        }elseif ( $_SESSION["rol"] === "winkelpersoneel" )  {

        }elseif ( $_SESSION["rol"] === "chauffeur" )  {

        }else {

        }
?>
</body>
</html>


<!-- 
Document Name: home.php
Made by: Sem van Haaften
-->