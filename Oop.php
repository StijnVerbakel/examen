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

    function __construct() 
    {
       
            $database = new Database();
            $conn = $database->conn;
            session_start();

       
     
        {
            if (!empty($_POST["table"])) {$table = $_POST["table"];} elseif(isset($_SESSION["table"])) {$table = $_SESSION["table"];} else {$table = "personeel";}
            // Haal de kolomnamen op uit de database
            $stmt = $conn->prepare("DESCRIBE $table");
            $stmt->execute();
            $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            $_SESSION["table"] = $table;
            if (!empty($_GET)) 
            {
               
               $id = $_GET["menuid"];
               $sql = "DELETE FROM $table WHERE Id = $id";
               $conn->exec($sql);
               header("location: ./crud.php");
            } 
            
            ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <?php foreach ($columns as $column) { ?>
                            <th><?php echo htmlspecialchars($column); ?></th>
                        <?php } ?>
                        <th>Acties</th>
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
                            <td>
                                <?php
                                echo "<a href='./edit.php?menuid=" . $row['Id'] . "&table=" . $table . "'>E</a>";
                                echo "<a href='./crud.php?menuid=" . $row['Id'] . "'>D</a>";
                                ?>
                            </td>
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

        if(!empty($_POST)) // edit verwerken
        {
            try {
                $tableEdit = $_SESSION["tableEdit"];
                $idEdit = $_SESSION["idEdit"];
                // Set PDO error mode
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                // Start building the SQL query
                $sql = "UPDATE $tableEdit SET ";
                $params = [];
                foreach ($_POST as $column => $value) {
                    // Skip if the column is empty
                    if (!empty($value)) {
                        $sql .= "$column = :$column, ";
                        $params[$column] = $value;
                    }
                }
            
                // Remove the trailing comma and space
                $sql = rtrim($sql, ', ');
            
                // Add the WHERE clause
                $sql .= " WHERE id = :id";
                $params['id'] = $idEdit;
            
                // Prepare and execute the statement
                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
            
                unset($_POST);
                // Redirect to the admin panel
                header("Location: ./crud.php");
                exit;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
      

        $table = $_GET["table"];
        $id = $_GET["menuid"];
        $_SESSION["tableEdit"] = $table;
        $_SESSION["idEdit"] = $id;
        
        $edit = $conn->prepare("SELECT * FROM $table WHERE Id = :id");
        $edit->bindParam(':id', $id, PDO::PARAM_INT);
        $edit->execute();
        $edit->setFetchMode(PDO::FETCH_ASSOC);
        $editdata = $edit->fetch();
        
        if ($editdata) 
        {
            echo '<form method="POST" action="./edit.php">';
            foreach ($editdata as $key => $value) {
                echo '<div>';
                echo '<label for="' . htmlspecialchars($key) . '">' . htmlspecialchars($key) . ':</label>';
                if ($key === 'ProductText') {
                    // Textarea for longer text
                    echo '<textarea name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '">' . htmlspecialchars($value) . '</textarea>';
                } elseif ($key === 'ProductFoto') {
                    // File input for photo
                    echo '<input type="file" name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '">';
                    echo '<p>Current File: ' . htmlspecialchars($value) . '</p>';
                } else {
                    // Standard text input
                    echo '<input type="text" name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                }
                echo '</div>';
            }
            echo '<button type="submit">Submit</button>';
            echo '<button onclick="window.location.href=\'./crud.php\'">Admin</button>'; 
            echo '</form>';
        } 
        else 
        {
            echo 'No data found.';
        } 
    }  
}
?>

<!-- 
Document Name: Oop.php
Made by: Stijn Verbakel
-->