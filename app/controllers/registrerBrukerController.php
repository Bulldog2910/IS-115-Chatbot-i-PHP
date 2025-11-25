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