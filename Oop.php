<link rel="stylesheet" href="styles.css">
<?php
// Database connection class using PDO
class Database
{
    private $db = "localhost"; // Database host
    private $dbname = "centrumduurzaam"; // Database name
    private $user = "root"; // Database username
    private $pass = ""; // Database password
    public $conn;

    function __construct()
    {
        try {
            // Establish a database connection using PDO
            $connection = new PDO("mysql:host=$this->db;dbname=$this->dbname", $this->user, $this->pass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn = $connection;

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage(); // Display connection error
        }
    }
}

// Login class to handle user authentication
class login
{
    function __construct()
    {
        if (!empty($_POST['username'])) { // Check if username is provided
            $username = $_POST['username'];
            $password = $_POST['password'];
            $database = new Database();
            $conn = $database->conn;

            // Retrieve user role and ID based on username
            $rol = $conn->prepare("SELECT rollen,id,gebruikersnaam FROM gebruiker WHERE Gebruikersnaam LIKE '%$username%'");
            $rol->execute();
            $rol->setFetchMode(PDO::FETCH_ASSOC);
            $rolreturn = $rol->fetch();

            if (!empty($rolreturn["gebruikersnaam"])) { // Check if user exists

                // Retrieve hashed password from database
                $ps = $conn->prepare("SELECT wachtwoord FROM gebruiker WHERE gebruikersnaam = '$username'");
                $ps->execute();
                $ps->setFetchMode(PDO::FETCH_ASSOC);
                $psreturn = $ps->fetch();
                $psreturn = ($psreturn["wachtwoord"]);

                if (password_verify($password, $psreturn)) // Verify password
                {
                    echo "<br> ingeloged";
                    unset($_POST); // Clear POST data
                    session_start();
                    $_SESSION["rol"] = $rolreturn['rollen']; // Store role in session
                    $_SESSION["username"] = $username; // Store username in session
                    $_SESSION["userId"] = $rolreturn["id"];   // Store user ID in session

                    header("location: home.php"); // Redirect to home page
                } else {
                    echo "<br> inloggen gefaalt"; // Login failed
                }
            } else {
                echo "incorrecte gegevens"; // Incorrect credentials
            }
        }
    }
}

// Class to handle user registration
class registreren
{
    function __construct()
    {
        if (!empty($_POST['Rol'])) {

            $Rol = $_POST['Rol'];
            $GebruikersNaam = $_POST['gebruikersnaam'];
            $Wachtwoord = $_POST['wachtwoord'];
            $database = new Database();
            $conn = $database->conn;

            // Hash the password before storing it
            $passwordhash = password_hash($Wachtwoord, PASSWORD_DEFAULT);

            // Check if username already exists
            $gmailC = $conn->prepare("SELECT gebruikersnaam FROM gebruiker WHERE gebruikersnaam LIKE '$GebruikersNaam'");
            $gmailC->execute();
            $gmailC->setFetchMode(PDO::FETCH_ASSOC);
            $gmailreturn = $gmailC->fetch();

            if (empty($gmailreturn)) { // If username is available
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO gebruiker (rollen, gebruikersnaam, wachtwoord) VALUES ('$Rol', '$GebruikersNaam', '$passwordhash')";

                $conn->exec($sql);
                echo "New record created successfully";
                header("Location:gebruiker.php");
            } else {
                echo "op dit gmail is al een account aangemaakt ";
            }
            unset($_POST);
            $conn = null;
        }
    }
}

// Class to handle CRUD operations on tables
class Table
{
    function __construct($table, $readonly, $cansee)
    {
        $database = new Database();
        $conn = $database->conn;
        if (empty($_SESSION)) {
            header("Location:index.php");
        }


        // Retrieve table columns
        $stmt = $conn->prepare("DESCRIBE $table");
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $_SESSION["previouslink"] = $_SERVER['REQUEST_URI'];
        $_SESSION["table"] = $table;
        
        if ((string)$_SESSION["table"]!="gebruiker"){
        echo "<a href='add.php?table=" . $table . "'class='add addbutton'>Maak aan</a>";
        }
        if (!empty($_GET)) {
            $id = $_GET["menuid"];
            $sql = "DELETE FROM $table WHERE id = $id";
            $conn->exec($sql);
            $url = strtok($_SERVER['REQUEST_URI'], '?');
            header("location: " . $url . "");
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
                    if ($readonly == false) { ?>
                        <th>Acties</th>
                    <?php } ?>
                </tr>
            </thead>

            <tbody>
                <?php
                // Fetch data from table
                $stmt = $conn->prepare("SELECT * FROM $table");
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($data as $row) { ?>
                    <tr>
                        <?php foreach ($columns as $column) { ?>
                            <td><?php echo htmlspecialchars($row[$column]); ?></td>
                        <?php } ?>
                        <?php if ($readonly == false) { ?>
                            <td>
                                <?php
                                echo "<a href='./edit.php?menuid=" . $row['id'] . "&table=" . $table . "'>Edit</a>";
                                echo "<a href='" . $_SERVER['REQUEST_URI'] . "?menuid=" . $row['id'] . "'>Delete</a>";
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

// Klasse voor het bewerken van gegevens in de database
class edit
{
    function __construct()
    {
        // Maak verbinding met de database
        $database = new Database();
        $conn = $database->conn;
        session_start();

        // Controleer of er een POST-verzoek is ontvangen (bewerkgegevens verwerken)
        if (!empty($_POST)) {
            try {
                $tableEdit = $_SESSION["tableEdit"];
                $idEdit = $_SESSION["idEdit"];

                // Stel de PDO foutmodus in
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "UPDATE $tableEdit SET "; // Start de query voor het bijwerken van gegevens
                $params = [];

                // Loop door de POST-gegevens en voeg kolommen toe aan de query
                foreach ($_POST as $column => $value) {
                    if (!empty($value)) { // Sla lege waarden over
                        $sql .= "$column = :$column, ";
                        $params[$column] = $value;
                    }
                }

                // Verwijder de laatste komma uit de query
                $sql = rtrim($sql, ', ');
                $sql .= " WHERE id = :id"; // Voeg de WHERE-clausule toe
                $params['id'] = $idEdit;

                $stmt = $conn->prepare($sql);
                $stmt->execute($params); // Voer de query uit

                unset($_POST); // Leeg de POST-gegevens
                $previouslink = $_SESSION["previouslink"];
                $url = strtok($previouslink, '?');
                header("Location: " . $url); // Ga terug naar de vorige pagina
                exit;
            } catch (PDOException $e) {
                // Behandel buitenlandse sleutelconstraintfouten
                if ($e->getCode() == '23000' && strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
                    echo "<p class='error'>Een van de id's die is ingevoerd is niet gevonden, weet je zeker dat het bestaat?</p>";
                    exit;
                } else {
                    echo "Error: " . $e->getMessage();
                }
            }
        }

        $table = $_GET["table"];
        $id = $_GET["menuid"];
        $_SESSION["tableEdit"] = $table;
        $_SESSION["idEdit"] = $id;

        // Selecteer de rij op basis van het id en de tabel
        $edit = $conn->prepare("SELECT * FROM $table WHERE Id = :id");
        $edit->bindParam(':id', $id, PDO::PARAM_INT);
        $edit->execute();
        $edit->setFetchMode(PDO::FETCH_ASSOC);
        $editdata = $edit->fetch();

        if ($editdata) {  // Genereer een formulier om gegevens te bewerken
            echo '<form method="POST" action="./edit.php">';
            foreach ($editdata as $key => $value) {
                echo '<div>';
                echo '<label for="' . htmlspecialchars($key) . '">' . htmlspecialchars($key) . ':</label>';
                if ($key === 'ProductText') {
                    echo '<textarea name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '"></textarea>';
                } elseif ($key === 'ophalen_of_bezorgen') {
                    echo '<select name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '">';
                    echo '<option value="Ophalen">Ophalen</option>';
                    echo '<option value="Bezorgen">Bezorgen</option>';
                    echo '</select>';
                } elseif ($key === 'afspraak_op' || $key === 'ingeboekt_op' || $key === 'verkocht_op'|| $key === 'vertek' || $key === 'aankomst') {
                    echo '<input type="datetime-local" name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                } else {
                    echo '<input type="text" name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                }
                echo '</div>';
            }
            echo '<button type="submit">Submit</button>';
            echo '</form>';
        } else {
            echo 'Geen gegevens gevonden.';
        }
    }
}

// Klasse om nieuwe gegevens toe te voegen aan een tabel
class Add
{
    function __construct()
    {
        $database = new Database();
        $conn = $database->conn;
        session_start();

        if (!empty($_POST)) {
            $this->handleFormSubmit($conn); // Verwerk formulierinzending
        }

        $this->displayForm($conn); // Toon het formulier om gegevens toe te voegen
    }

    // Verwerk de formulierinzending en voeg gegevens toe aan de database
    private function handleFormSubmit($conn)
    {
        try {
            $tableAdd = $_GET["table"];

            if (empty($tableAdd)) {
                echo 'Tabelnaam ontbreekt.';
                exit;
            }

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO $tableAdd (";
            $sqlValues = "VALUES (";
            $params = [];

            foreach ($_POST as $column => $value) {
                if (!empty($value)) {
                    $sql .= "$column, ";
                    $sqlValues .= ":$column, ";
                    $params[$column] = $value;
                }
            }

            $sql = rtrim($sql, ', ') . ') ';
            $sqlValues = rtrim($sqlValues, ', ') . ')';
            $sql .= $sqlValues;

            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            $previouslink = $_SESSION["previouslink"];
            $url = strtok($previouslink, '?');
            header("Location: " . $url);
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == '23000' && strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
                echo "<p class='error'>Een van de id's die is ingevoerd is niet gevonden, weet je zeker dat het bestaat?</p>";
            } else {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    // Toon het formulier voor het toevoegen van gegevens
    private function displayForm($conn)
    {
        $tableAdd = $_GET["table"];
        $_SESSION["tableAdd"] = $tableAdd;
        $previouslink = $_SESSION["previouslink"];

        $columns = $conn->prepare("DESCRIBE $tableAdd");
        $columns->execute();

        if ($columns->rowCount() > 0) {
            $columnsData = $columns->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "Geen kolommen gevonden voor tabel $tableAdd.";
            exit;
        }

        echo '<form method="POST" action="./add.php?table=' . $tableAdd . '">';
        foreach ($columnsData as $column) {
            $key = $column['Field'];
            if ($key !== 'id') {
                echo '<div>';
                echo '<label for="' . htmlspecialchars($key) . '">' . htmlspecialchars($key) . ':</label>';
                if ($key === 'ProductText') {
                    echo '<textarea name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '"></textarea>';
                } elseif ($key === 'ophalen_of_bezorgen') {
                    echo '<select name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '">';
                    echo '<option value="Ophalen">Ophalen</option>';
                    echo '<option value="Bezorgen">Bezorgen</option>';
                    echo '</select>';
                } elseif ($key === 'afspraak_op' || $key === 'ingeboekt_op' || $key === 'verkocht_op'|| $key === 'vertek' || $key === 'aankomst') {
                    echo '<input type="datetime-local" name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '">';
                } else {
                    echo '<input type="text" name="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '">';
                }
                echo '</div>';
            }
        }
        echo '<button type="submit">Submit</button>';
        echo '</form>';
    }
}

// Klasse voor wachtwoord vergeten functionaliteit
class pwf
{
    function __construct()
    {
        $database = new Database();
        $conn = $database->conn;
        if ($_POST) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Hash het wachtwoord voordat het wordt opgeslagen
            $passwordhash = password_hash($password, PASSWORD_DEFAULT);

            // Controleer of de gebruikersnaam bestaat in de database
            $gCeck = $conn->prepare("SELECT gebruikersnaam FROM gebruiker WHERE gebruikersnaam LIKE '$username'");
            $gCeck->execute();
            $gCeck->setFetchMode(PDO::FETCH_ASSOC);
            $gCheckReturn = $gCeck->fetch();

            if (!empty($gCheckReturn)) {
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE gebruiker SET wachtwoord = '$passwordhash' WHERE gebruikersnaam = '$username';";
                $conn->exec($sql);
                header("location: index.php");
            } else {
                echo "Geen geldig gebruikersnaam";
            }
        }
    }
}
?>

<!-- 
Document Naam: Oop.php
Gemaakt door: Anouk Grandia, Lauro El-Bagdadi, Stijn Verbakel en Sem van Haaften
-->