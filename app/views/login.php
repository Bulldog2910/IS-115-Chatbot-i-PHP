<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
include '_header.php';

$errorMsg = array();
$email = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) 
    // Hent og rens input
    $email = trim($_POST['email'] ?? "");
    $password = trim($_POST['password'] ?? "");

    // Valider email
    if (!$email) {
        $errorMsg['email'] = "E-post må oppgis";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg['email'] = "Ugyldig e-postadresse";
    }

   // Valider passord med spesifikke krav
if (!$password) {
    $errorMsg['password'] = "Passord må oppgis";
}

// Hvis ingen feil, fortsett med login
if (!count($errorMsg)) {

    include __DIR__ . '/../config/db.php';

    $conn->select_db('FAQUiaChatbot');

    $stmt = $conn->prepare('SELECT * FROM chatUser WHERE mail = ?');
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    

    if($result->num_rows !== 0){
        $row = $result->fetch_assoc();
        if($row['userpassword'] == $_POST['password']){
            $_SESSION['user_id'] = 1;
            $_SESSION['username'] = $row['username'];
            header("Location: ../../public/Index.php");
            exit(); 
        }else{
            $errorMsg['Wrong password'] = "Feil passord";
        }
    }else{
        $errorMsg['login'] = "Feil email eller passord";

    }
}
?>

<div class="login-container">
    <h2>Logg inn</h2>

    <?php if (count($errorMsg)): ?>
        <link rel="stylesheet" href="../../public/css/login.css">
        <div class="error-messages">
            <ul style="color:red;">
                <?php foreach ($errorMsg as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="email">E-post:</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   required 
                   value="<?php echo htmlspecialchars($email); ?>"
                   placeholder="Din e-post">
        </div>

        <div class="form-group">
            <label for="password">Passord:</label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   required 
                   placeholder="123">
        </div>

        <button type="submit" name="login" class="button">Logg inn</button>
    </form>
    <a class="button" href="./userCreation.php">User creation</a>
</div>

<?php include '_footer.php'; ?>