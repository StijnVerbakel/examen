<?php
include_once('Oop.php');
session_start();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu in Div</title>
    <style> 


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

            <button class="NavButton">Artikelen bekijken</button>
        </div></a>';
        echo'
        <a href="magazijn.php"><div class="grid-item"> 
    
                <button class="NavButton">Magazijn bekijken</button>
            </div></a>';
            echo'
        <a href="categorie.php"><div class="grid-item"> 
    
                <button class="NavButton">Categorie bekijken</button>
            </div></a>';
        }elseif ( $_SESSION["rol"] === "directie" )  {
            echo'
            <a href="artikelen.php"><div class="grid-item"> 
        
                    <button class="NavButton">Artikelen bekijken</button>
                </div></a>';
                echo'
                <a href="magazijn.php"><div class="grid-item"> 
            
                        <button class="NavButton">Magazijn bekijken</button>
                    </div></a>';
                    echo'
                <a href="categorie.php"><div class="grid-item"> 
            
                        <button class="NavButton">Categorie bekijken</button>
                    </div></a>';
                    echo'
    <a href="gebruiker.php"><div class="grid-item"> 

            <button class="NavButton">Gebruikers bekijken</button>
        </div></a>';
        echo'
        <a href="klant.php"><div class="grid-item"> 
    
                <button class="NavButton">Klanten bekijken</button>
            </div></a>';
            echo'
        <a href="status.php"><div class="grid-item"> 
    
                <button class="NavButton">Status bekijken</button>
            </div></a>';
        
            echo'
            <a href="verkopen.php"><div class="grid-item"> 
        
                    <button class="NavButton">Verkopen bekijken</button>
                </div></a>';

                echo'
                <a href="planning.php"><div class="grid-item"> 
            
                        <button class="NavButton">Planning bekijken</button>
                    </div></a>';
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