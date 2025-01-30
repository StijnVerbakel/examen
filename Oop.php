<link rel="stylesheet" href="styles.css">
<?php 
class Database //database connection 
{
    private $db = "localhost";
    private $dbname = "centrumduurzaam";
    private $user = "root";
    private $pass = "";
    public $conn;

    function __construct() {
        try {
            $connection = new PDO("mysql:host=$this->db;dbname=$this->dbname", $this->user, $this->pass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn = $connection;
          
        }  catch (PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
    }
}

class login //login backend (after the post)
{
    function __construct() 
    {
        if (!empty($_POST['username']))
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $database = new Database();
            $conn = $database->conn; 
        
            $rol = $conn->prepare("SELECT rollen,id,gebruikersnaam From gebruiker WHERE Gebruikersnaam LIKE '%$username%'"); // haal rol van gebruiker uit database
            $rol->execute();
            $rol->setFetchMode(PDO::FETCH_ASSOC);
            $rolreturn = $rol->fetch();
            
            if (!empty($rolreturn["gebruikersnaam"]))
            { //bestaat email?
           
                $ps = $conn->prepare("SELECT wachtwoord FROM gebruiker WHERE gebruikersnaam = '$username'"); // haal het juiste password uit de database
                $ps->execute();
                $ps->setFetchMode(PDO::FETCH_ASSOC);
                $psreturn = $ps->fetch();
                $psreturn = ($psreturn["wachtwoord"]);
          
                if (password_verify($password, $psreturn)) // check password correct
                { // email en wachtwoord overeen?
                    echo "<br> ingeloged";
                    unset($_POST); // leeg $_Post
                    session_start();
                    $_SESSION["rol"] = $rolreturn['rollen']; // rol sesion
                    $_SESSION["username"] = $username; // username session
                    $_SESSION["userId"] = $rolreturn["id"];   // userid session
                 
                    header("location: home.php");
                } 
                else
                {
                    echo "<br> inloggen gefaalt"; 

                }
            }
            else
            {
                echo "incorrecte gegevens";
                
            }
        }
    }
}

class registreren //registreren van een nieuw persoon/gebruiker in het systeem
{
    function __construct() 
    {  

        if (!empty($_POST['Rol']))
        {
            
            $Rol = $_POST['Rol'];
            $GebruikersNaam = $_POST['gebruikersnaam'];
            $Wachtwoord = $_POST['wachtwoord'];
            $database = new Database();
            $conn = $database->conn;
       
            $passwordhash = password_hash($Wachtwoord,PASSWORD_DEFAULT);
            $gmailC = $conn->prepare("SELECT gebruikersnaam From gebruiker WHERE gebruikersnaam LIKE '$GebruikersNaam'"); // zoek oof er al een acount is op dit gmail
            $gmailC->execute();
            $gmailC->setFetchMode(PDO::FETCH_ASSOC);
            $gmailreturn = $gmailC->fetch();

            // maak acount
            if (empty($gmailreturn))
            { 
                 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $sql = "INSERT INTO gebruiker (rollen, gebruikersnaam, wachtwoord) VALUES ('$Rol', '$GebruikersNaam', '$passwordhash')"; // voegt acount to in database
                        
                
                 $conn->exec($sql);
                echo "New record created successfully"; 
            
               // header("location: index.php");            
                
                
            
            }
            else 
            {
                echo "op dit gmail is al een acount aangemaakt ";
                   
            } 
            unset($_POST); 
            $conn = null;
        }
    }
}

class Table // Crud table + delete
{

    function __construct($table,$readonly, $cansee) 
    {
       
            $database = new Database();
            $conn = $database->conn;
            //session_start();

       
     
        {
            echo "<a href='add.php?table=". $table. "'class='add addbutton'>Maak aan</a>";
            // Haal de kolomnamen op uit de database
            $stmt = $conn->prepare("DESCRIBE $table");
            $stmt->execute();
            $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $_SESSION["previouslink"] = $_SERVER['REQUEST_URI'];
            $_SESSION["table"] = $table;
            if (!empty($_GET)) 
            {
               
               $id = $_GET["menuid"];
               $sql = "DELETE FROM $table WHERE id = $id";
               $conn->exec($sql);
               $url = strtok($_SERVER['REQUEST_URI'], '?');

               header("location: ".$url."");
            } 
            if ($cansee == false) {
                header("location: home.php");

            }
            ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <?php foreach ($columns as $column) { ?>
                            <th><?php echo htmlspecialchars($column); ?></th>
                        <?php }
                        if ($readonly == false) {
                        ?>
                    
                        <th>Acties</th>
                        <?php }?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    // Haal de gegevens op uit de tabel
                    $stmt = $conn->prepare("SELECT * FROM $table");
                    $stmt->execute();
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($data as $row) 
                    {
                        ?>
                        <tr>
                            <?php foreach ($columns as $column) { ?>
                                <td><?php echo htmlspecialchars($row[$column]); ?></td>
                            <?php } ?>
                            <?php if ($readonly == false) { ?>
                            <td>
                                <?php
                                echo "<a href='./edit.php?menuid=" . $row['id'] . "&table=" . $table . "'>E</a>";
                                echo "<a href='".$_SERVER['REQUEST_URI']."?menuid=" . $row['id'] . "'>D</a>";
                                ?>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
       
        }
            
    }
}

class edit // edit data
{
    function __construct() 
    {
        $database = new Database();
        $conn = $database->conn;
        session_start();

        if(!empty($_POST)) // edit verwerken waarneer post is ingevult
        {
            try {
                $tableEdit = $_SESSION["tableEdit"];
                $idEdit = $_SESSION["idEdit"];
                // Set PDO error mode
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                
                $sql = "UPDATE $tableEdit SET "; // maak de query
                $params = [];
                foreach ($_POST as $column => $value) { // 
                    if (!empty($value)) { // als empty sla over anders voeg toe aan query
                        $sql .= "$column = :$column, ";
                        $params[$column] = $value;
                    }
                }
            
                $sql = rtrim($sql, ', '); // trim sql
            
               
                $sql .= " WHERE id = :id"; // voeg where toe aan sql query
                $params['id'] = $idEdit;
            
                
                $stmt = $conn->prepare($sql);
                $stmt->execute($params); // voer de query uit
            
                unset($_POST); // leeg post
                $previouslink = $_SESSION["previouslink"];
                $url = strtok($previouslink, '?');
                header("Location: ".$url.""); // ga terug naar last link
                exit;
            } 
            catch (PDOException $e) 
            {
                echo "Error: " . $e->getMessage();
            }
        }
      

        $table = $_GET["table"];
        $id = $_GET["menuid"];
        $_SESSION["tableEdit"] = $table;
        $_SESSION["idEdit"] = $id;
        
        $edit = $conn->prepare("SELECT * FROM $table WHERE Id = :id"); // selecteer opbasis van het id en de table de row om de bewerken
        $edit->bindParam(':id', $id, PDO::PARAM_INT);
        $edit->execute();
        $edit->setFetchMode(PDO::FETCH_ASSOC);
        $editdata = $edit->fetch();
        
        if ($editdata)  //maak de form
        {
            echo '<form method="POST" action="./edit.php">';
            foreach ($editdata as $key => $value) {
                echo '<div>';
                echo '<label for="' . htmlspecialchars($key) . '">' . htmlspecialchars($key) . ':</label>';
               if ($key === 'ProductText') {
                // Textarea for longer text
                echo '<textarea name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '"></textarea>';
            } elseif ($key === 'ophalen_of_bezorgen') {
                // File input for photo (Note: Make sure to handle file uploads correctly)
                echo '<select name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '">';
                echo '<option value="Ophalen">Ophalen</option>';
                echo '<option value="Bezorgen">Bezorgen</option>';
                echo '</select>';
                            } elseif ($key === 'afspraak_op') {
                // File input for photo (Note: Make sure to handle file uploads correctly)
                echo '<input type="datetime-local" name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '">';
            }
        elseif ($key === 'ingeboekt_op' || $key === "afspraak_op") {
            // File input for photo (Note: Make sure to handle file uploads correctly)
            echo '<input type="datetime-local" name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '"value="'.$key.'">';
        } else {
                // Standard text input
                echo '<input type="text" name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '"value="'.htmlspecialchars($value).'">';
            }
                echo '</div>';
            }
            echo '<button type="submit">Submit</button>';
            
            echo '<button onclick="window.location.href=\'./crud.php\'">Admin</button>'; 
            echo '</form>';
        } 
        else 
        {
            echo 'No data found.'; // catch
        } 
    }  
}

class Add // Add data to table
{
    function __construct() 
    {
        // Initialize the database connection
        $database = new Database();
        $conn = $database->conn;
        session_start();

        // Handle the form submission
        if (!empty($_POST)) {
            $this->handleFormSubmit($conn);
        }

        // Display the form for adding data to the new row
        $this->displayForm($conn);
    }

    // Function to handle form submission and insert data into the database
    private function handleFormSubmit($conn)
    {
        try {
            // Get the table name from the GET parameter
            $tableAdd = $_GET["table"];
            
            if (empty($tableAdd)) {
                echo 'Table name is missing.';
                exit;
            }

            // Set PDO error mode
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Start building the SQL query for INSERT
            $sql = "INSERT INTO $tableAdd (";
            $sqlValues = "VALUES (";
            $params = [];

            // Loop through the POST data and prepare columns and values
            foreach ($_POST as $column => $value) {
                // Skip if the column is empty
                if (!empty($value)) {
                    $sql .= "$column, ";
                    $sqlValues .= ":$column, ";
                    $params[$column] = $value;
                }
            }

            // Remove the trailing commas and spaces
            $sql = rtrim($sql, ', ') . ') ';
            $sqlValues = rtrim($sqlValues, ', ') . ')';

            // Complete the final SQL query
            $sql .= $sqlValues;

            // Prepare and execute the statement
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            $previouslink = $_SESSION["previouslink"];
            $url = strtok($previouslink, '?');

            // Redirect to the admin panel after adding the data
            header("Location: ".$url."");
            
            exit;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Function to display the form for adding data to the table
    private function displayForm($conn)
    {
        // Get the table name from the GET parameter
        $tableAdd = $_GET["table"];
        $_SESSION["tableAdd"] = $tableAdd;
        $previouslink = $_SESSION["previouslink"];

        // Fetch the table column names
        $columns = $conn->prepare("DESCRIBE $tableAdd");
        $columns->execute();

        // Debugging: Check if columns are returned
        if ($columns->rowCount() > 0) {
            $columnsData = $columns->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "No columns found for table $tableAdd.";
            exit;
        }

        // Start the form
        echo '<form method="POST" action="./add.php?table='.$tableAdd.'">'; // Change action to match the correct script
        foreach ($columnsData as $column) {
            
            $key = $column['Field'];
            if ($key == 'id') {
            }else{
            echo '<div>';
            echo '<label for="' . htmlspecialchars($key) . '">' . htmlspecialchars($key) . ':</label>';

            // Render different input types based on column name
            if ($key === 'ProductText') {
                // Textarea for longer text
                echo '<textarea name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '"></textarea>';
            } elseif ($key === 'ophalen_of_bezorgen') {
                // File input for photo (Note: Make sure to handle file uploads correctly)
                echo '<select name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '">';
                echo '<option value="Ophalen">Ophalen</option>';
                echo '<option value="Bezorgen">Bezorgen</option>';
                echo '</select>';
                            } elseif ($key === 'afspraak_op') {
                // File input for photo (Note: Make sure to handle file uploads correctly)
                echo '<input type="datetime-local" name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '">';
            }
        elseif ($key === 'ingeboekt_op') {
            // File input for photo (Note: Make sure to handle file uploads correctly)
            echo '<input type="datetime-local" name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '">';
        } else {
                // Standard text input
                echo '<input type="text" name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '">';
            }
            echo '</div>';
            }}

        // Submit button for the form
        echo '<button type="submit">Submit</button>';
        echo '</form>';
    }
}

class pwf // wachtwoord vergeten 
{
    function __construct() 
    {
        $database = new Database(); // database connectie
        $conn = $database->conn;
        $username = $_GET["username"]; // info uit get
        $password = $_GET["password"];

        $passwordhash = password_hash($password,PASSWORD_DEFAULT); // password hash voor de set in database

        $gCeck = $conn->prepare("SELECT gebruikersnaam From gebruiker WHERE gebruikersnaam LIKE '$username'"); // kijk of username er wel is
        $gCeck->execute();
        $gCeck->setFetchMode(PDO::FETCH_ASSOC);
        $gCheckReturn = $gCeck->fetch();

        if (!empty($gCheckReturn)) //als username bestaad voer het uit ander geef echo message uit
        {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE gebruiker SET wachtwoord = '$passwordhash' WHERE gebruikersnaam = '$username';"; // update het nieuwe wachtwoord in de database
            $conn->exec($sql);
            header("location: index.php");
        }
        else 
        {
            echo "Geen geldig gebruikersnaam";
        }
    } 
}
?>

<!-- 
Document Name: Oop.php
Made by: Anouk Grandia, Lauro El-Bagdadi, Stijn Verbakel en Sem van Haaften
-->