<?php
include_once('Oop.php'); // Laad de benodigde klasse Oop
session_start(); // Start de sessie

// Controleer of de sessie variabele "rol" leeg is, zo ja, stuur de gebruiker naar de loginpagina
if ($_SESSION["rol"] == null) {
    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu in Div</title>
    <style>
        /* Hier kunnen we de CSS toevoegen voor styling van de pagina */
    </style>
</head>

<body>
    <header class="menu">
        <h1>Kringloop Centrum</h1>
        <!-- Link naar de logout pagina -->
        <a href="Logout.php">Logout</a>
    </header>

    <!-- Dit is het grid waar de menu-opties worden weergegeven -->
    <div class="grid-container">
        <?php
        // Controleer de rol van de gebruiker en geef de juiste opties weer

        // Als de rol van de gebruiker 'magazijn' is
        if ($_SESSION["rol"] === "magazijn") {
            echo '
            <a href="artikelen.php"><div class="grid-item"> 
            <button class="NavButton">Artikelen bekijken</button>
            </div></a>';
            echo '
             <a href="magazijn.php"><div class="grid-item"> 
            <button class="NavButton">Magazijn bekijken</button>
            </div></a>';
            echo '
            <a href="categorie.php"><div class="grid-item"> 
            <button class="NavButton">Categorie bekijken</button>
            </div></a>';
        } 
        // Als de rol van de gebruiker 'directie' is
        elseif ($_SESSION["rol"] === "directie") {
            echo '
            <a href="artikelen.php"><div class="grid-item"> 
            <button class="NavButton">Artikelen bekijken</button>
            </div></a>';
            echo '
            <a href="magazijn.php"><div class="grid-item"> 
            <button class="NavButton">Magazijn bekijken</button>
            </div></a>';
            echo '
            <a href="categorie.php"><div class="grid-item"> 
                <button class="NavButton">Categorie bekijken</button>
            </div></a>';
            echo '
            <a href="gebruiker.php"><div class="grid-item"> 
                <button class="NavButton">Gebruikers bekijken</button>
            </div></a>';
            echo '
            <a href="klant.php"><div class="grid-item"> 
                <button class="NavButton">Klanten bekijken</button>
            </div></a>';
            echo '
            <a href="status.php"><div class="grid-item"> 
                <button class="NavButton">Status bekijken</button>
            </div></a>';
            echo '
            <a href="verkopen.php"><div class="grid-item"> 
                <button class="NavButton">Verkopen bekijken</button>
            </div></a>';
            echo '
            <a href="planning.php"><div class="grid-item"> 
                <button class="NavButton">Planning bekijken</button>
            </div></a>';
            echo '
            <a href="ritten.php"><div class="grid-item"> 
                <button class="NavButton">Ritten bekijken</button>
            </div></a>';
        } 
        // Als de rol van de gebruiker 'winkelpersoneel' is
        elseif ($_SESSION["rol"] === "winkelpersoneel") {
            echo '
            <a href="verkopen.php"><div class="grid-item"> 
                <button class="NavButton">Verkopen bekijken</button>
            </div></a>';
            echo '
            <a href="klant.php"><div class="grid-item"> 
                <button class="NavButton">Klanten bekijken</button>
            </div></a>';
            echo '
            <a href="artikelen.php"><div class="grid-item"> 
                <button class="NavButton">Artikelen bekijken</button>
            </div></a>';
            echo '
            <a href="magazijn.php"><div class="grid-item"> 
                <button class="NavButton">Magazijn bekijken</button>
            </div></a>';
        } 
        // Als de rol van de gebruiker 'chauffeur' is
        elseif ($_SESSION["rol"] === "chauffeur") {
            echo '
            <a href="planning.php"><div class="grid-item"> 
                <button class="NavButton">Planning bekijken</button>
            </div></a>';
            echo '
            <a href="status.php"><div class="grid-item"> 
                <button class="NavButton">Status bekijken</button>
            </div></a>';
            echo '
            <a href="verkopen.php"><div class="grid-item"> 
                <button class="NavButton">Verkopen bekijken</button>
            </div></a>';
            echo '
            <a href="magazijn.php"><div class="grid-item"> 
                <button class="NavButton">Magazijn bekijken</button>
            </div></a>';
            echo '
            <a href="ritten.php"><div class="grid-item"> 
                <button class="NavButton">Ritten bekijken</button>
            </div></a>';
        } else {
            // Als de rol van de gebruiker niet gedefinieerd is, doen we niets
        }
        ?>
    </div>
</body>

</html>

<!-- 
Document Naam: home.php
Gemaakt door: Anouk Grandia, Lauro El-Bagdadi, Stijn Verbakel en Sem van Haaften
-->
