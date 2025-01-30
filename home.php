<?php
include_once('Oop.php');
session_start();
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


    </style>
</head>

<body>
    <header class="menu">
        <h1>Kringloop Centrum</h1>
        <a href="Logout.php">Logout</a>



    </header>
    <div class="grid-container">
        <?php
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
        } elseif ($_SESSION["rol"] === "directie") {
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
        } elseif ($_SESSION["rol"] === "winkelpersoneel") {
            echo '
            <a href="verkopen.php"><div class="grid-item"> 
        
                    <button class="NavButton">Verkopen bekijken</button>
                </div></a>';

            echo '
                    <a href="klant.php"><div class="grid-item"> 
                
                            <button class="NavButton">Klanten bekijken</button>
                        </div></a>';
            echo '            <a href="artikelen.php"><div class="grid-item"> 
        
                    <button class="NavButton">Artikelen bekijken</button>
                </div></a>';
            echo '
                <a href="magazijn.php"><div class="grid-item"> 
            
                        <button class="NavButton">Magazijn bekijken</button>
                    </div></a>';
            echo '';
        } elseif ($_SESSION["rol"] === "chauffeur") {
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
                    echo '<a href="magazijn.php"><div class="grid-item"> 
    
                <button class="NavButton">Magazijn bekijken</button>
            </div></a>';
            
        } else {

        }
        ?>
</body>

</html>


<!-- 
Document Name: home.php
Made by: Anouk Grandia, Lauro El-Bagdadi, Stijn Verbakel en Sem van Haaften
-->