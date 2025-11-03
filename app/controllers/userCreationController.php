<?php
    // includes code from db.php to start connection to database
    include __DIR__ . '/../config/db.php';
    include __DIR__ . '/../controllers/dbController.php';
    
    // Reused code from modul 4 opg2
    // Repurposed create user form 
    $fname = $ename = $email = $password = $username = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = test_inputname($_POST["fnavn"]);
    $ename = test_inputname($_POST["enavn"]);
    $email = test_input($_POST["epost"]);
    $password = test_input($_POST["password"]);
    $username = test_input($_POST["username"]);
    }

    function test_inputname($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = strtolower($data);
    $data = ucfirst($data);
    return $data;
    }
    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = strtolower($data);
    return $data;
    }

    //Form validation and debugging
    if (isset($_POST['registrer'])) {
    $errorMsg = array();

    // First name
    if (!isset($_POST['fnavn']) || empty(trim($_POST['fnavn']))) {
        $errorMsg['A1-1'] = 'Fornavn må oppgis';
        echo "<style>.fnavn{ color: red; }</style>";
    } else {
        $fname = trim($_POST['fnavn']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
            $errorMsg['A1-2'] = "Only letters and white space allowed";
            echo "<style>.fnavn{ color: red; }</style>";
        }
    }

    // Last name
    if (!isset($_POST['enavn']) || empty(trim($_POST['enavn']))) {
        $errorMsg['A2-1'] = 'Etternavn må oppgis';
        echo "<style>.enavn{ color: red; }</style>";
    } else {
        $ename = trim($_POST['enavn']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $ename)) {
            $errorMsg['A2-2'] = "Only letters and white space allowed";
            echo "<style>.enavn{ color: red; }</style>";
        }
    }

    // Email
    if (!isset($_POST['epost']) || empty(trim($_POST['epost']))) {
        $errorMsg['A3-1'] = 'Email må oppgis';
        echo "<style>.epost{ color: red; }</style>";
    } else {
        $email = trim($_POST['epost']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg['A3-2'] = "Invalid email format";
            echo "<style>.epost{ color: red; }</style>";
        }
    }

    // Username
    if (!isset($_POST['username']) || empty(trim($_POST['username']))) {
        $errorMsg['A4-1'] = 'Username må oppgis';
        echo "<style>.username{ color: red; }</style>";
    } else {
        $username = trim($_POST['username']);
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
            $errorMsg['A4-2'] = "Only letters, numbers, underscores, 3-20 characters";
            echo "<style>.username{ color: red; }</style>";
        }
    }

    // Password
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $errorMsg['A5-1'] = 'Password må oppgis';
        echo "<style>.password{ color: red; }</style>";
    } else {
        $password = $_POST['password'];
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W]).{8,}$/", $password)) {
            $errorMsg['A5-2'] = "Password must be at least 8 chars with uppercase, lowercase, number, special char";
            echo "<style>.password{ color: red; }</style>";
        }
    }

    // No errors? Print info and insert into DB
    if (empty($errorMsg)) {
        $infoarr = array(
            "fname" => $fname,
            "ename" => $ename,
            "email" => $email,
            "password" => $password,
            "username" => $username
        );

        print_r($infoarr);
        echo "<br>Ditt navn er: $fname $ename <br>";
        echo "Din epost er: $email <br>";
        echo "Din username er: $username <br>";

        $insertIntoChatUser = "INSERT INTO chatUser (firstName, lastName, userpassword, mail, username) 
                               VALUES ('$fname', '$ename', '$password', '$email', '$username')";
                               
        if(mysqli_query($conn, $insertIntoChatUser)){ //this doesnt display anything
            echo "inserted into database correctly"; 
        }else{
            echo "error inserting into database";
        };
    } else {
        ksort($errorMsg);
        foreach ($errorMsg as $key => $val) {
            echo "Error: $key: $val <br>";
        }
    }
}
?>