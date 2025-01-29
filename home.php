<?php
include_once('Oop.php');
echo '<button onclick="window.location.href=\'Login.php\'">Go to Inlog</button>';
echo '<button onclick="window.location.href=\'./klant.php\'">Klant overzicht</button>';
session_start();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu in Div</title>
    <style> /* Algemene stijl voor de pagina */
/* Algemene stijl voor de pagina */
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
/*
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
    background-color: #007BFF; /* Blauwe achtergrond voor de dropdown-knop */
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Dropdown knop hover effect */
.dropdown:hover .dropbtn {
    background-color: #0056b3; /* Donkerblauw wanneer je over de knop hovert */
}

/* De dropdown-content (die standaard verborgen is) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 100px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 5px;
}

/* Links in de dropdown */<
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    font-size: 16px;
}

/* Verander de kleur van de links bij hover in de dropdown */
.dropdown-content a:hover {
    background-color: #ddd;
}

/* Toon de dropdown-content als je met de muis over de dropdown heen beweegt */
.dropdown:hover .dropdown-content {
    display: block;
}

 </style>
 <div class="menu">
        <h1>Kringloop Centrum</h1>
        <a href="#home">Home</a>

        <!-- Dropdown Menu voor Ritten -->
        <div class="dropdown">
            <button class="dropbtn">Ritten</button>
            <div class="dropdown-content">
                <a href="#rit1">Ritten planning</a>
            </div>
        </div>
        <a href="#contact">Voorraad</a>
        <a href="#over">Beheer</a>
        <!-- Dropdown Menu voor Admin -->
        <div class="dropdown">
            <button class="dropbtn">Admin</button>
            <div class="dropdown-content">
                <a href="#admin1">Ritten planning</a>
                <a href="#admin2">Voorraadbeheer</a>
                <a href="#admin3">Kledingstukken</a>
                <a href="#admin3">Klanten</a>
            </div> 
            <a style= "float:right;"href="#aanmelden">Aanmelden</a>

        </div>

    </div>
</head>
</html>


<!-- 
Document Name: home.php
Made by: Stijn Verbakel
-->