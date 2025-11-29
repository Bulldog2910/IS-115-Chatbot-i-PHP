<?php
include __DIR__ . '/../config/db.php';
include __DIR__ . '/../controllers/dbController.php';

// Default values that match the view
$firstName = $_POST['firstName'] ?? '';
$lastName = $_POST['lastName'] ?? '';
$userpassword  = $_POST['userpassword'] ?? ''; 
$mail = $_POST['mail'] ?? '';
$username  = $_POST['username'] ?? '';
$feil = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrer'])) {

    // Validation
    if (empty(trim($firstName))) $feil[] = "Fornavn må oppgis";
    if (empty(trim($lastName))) $feil[] = "Etternavn må oppgis";
    if (empty(trim($userpassword))) $feil[] = "Passord må oppgis"; 
    if (empty(trim($mail)) || !filter_var($mail, FILTER_VALIDATE_EMAIL)) $feil[] = "Ugyldig e-post";
    if (empty(trim($username))) $feil[] = "Brukernavn må oppgis";

    // If no errors → save to DB
    if (empty($feil)) {

        $sql = "INSERT INTO chatuser (firstName, lastName, userpassword, mail, username) 
                VALUES ('$firstName', '$lastName', '$userpassword', '$mail', '$username')";

        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green;'>Bruker registrert korrekt!</p>";
        } else {
            echo "<p style='color:red;'>Feil ved lagring i databasen: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>

<?php

require_once __DIR__ . '/../service/registerValidator.php';
require_once __DIR__ . '/../models/User/registerModel.php';

class RegisterController
{
    /**
     * Handles both GET and POST for the registration page.
     * - On GET: show empty form.
     * - On POST: validate input, save user if OK, redisplay view with errors or success.
     */
    public function register(): void
    {
        $errors  = [];
        $success = '';

        // Keep form values so user doesn’t lose input on validation errors
        $formData = [
            'firstName'      => $_POST['firstName']      ?? '',
            'lastName'       => $_POST['lastName']       ?? '',
            'username'       => $_POST['username']       ?? '',
            'mail'           => $_POST['mail']           ?? '',
            'userpassword'   => $_POST['userpassword']   ?? '',
            'repeatpassword' => $_POST['repeatpassword'] ?? '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1) Run validation on POST data
            $validator = new RegisterValidator($_POST);
            $errors    = $validator->validate();

            // 2) If no errors, create user via the model
            if (empty($errors)) {
                // You’d likely inject $conn or a DB class instead of new here
                global $conn; // or use DI; depends on how your app is wired
                $userModel = new NewUser($conn);

                // Hash password before saving
                $hashedPassword = password_hash($formData['userpassword'], PASSWORD_DEFAULT);

                $userModel->createUser([
                    'firstName' => $formData['firstName'],
                    'lastName'  => $formData['lastName'],
                    'username'  => $formData['username'],
                    'mail'      => $formData['mail'],
                    'password'  => $hashedPassword,
                ]);

                $success = "Bruker registrert!";

                // Optionally clear password fields after success
                $formData['userpassword']   = '';
                $formData['repeatpassword'] = '';
            }
        }

        // Make variables available to view
        $error   = $errors;
        $successMsg = $success;
        $data    = $formData;

        // Load the view
        require __DIR__ . '/../views/registerUser.view.php';
    }
}
