<?php

// Include the registration controller which handles form submission and validation
include __DIR__ . '/../controllers/registrerBrukerController.php';

?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Registrer ny bruker</title>
    <link rel="stylesheet" href="../../public/css/registrerBruker.css">
</head>
<body>
<h1>Registrer ny bruker</h1>

<?php if (!empty($feil)): ?>
    <ul style="color:red;">
        <?php foreach ($feil as $melding): ?>
            <li><?= htmlspecialchars($melding) ?></li> <!-- Display each error message -->
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (!empty($success ?? '')): ?>
    <p style="color:green;"><?= htmlspecialchars($success) ?></p> <!-- Display success message -->
<?php endif; ?>

<!-- Registration Form -->
<form method="post" action="">
    <label for="firstName">Fornavn:</label><br>
    <input type="text" id="firstName" name="firstName" value="<?= htmlspecialchars($firstName) ?>"><br><br>

    <label for="lastName">Etternavn:</label><br>
    <input type="text" id="lastName" name="lastName" value="<?= htmlspecialchars($lastName) ?>"><br><br>

    <label for="userpassword">Passord:</label><br>  
    <input type="password" id="userpassword" name="userpassword" value="<?= htmlspecialchars($userpassword) ?>"><br><br>

    <label for="mail">E-post:</label><br>
    <input type="text" id="mail" name="mail" value="<?= htmlspecialchars($mail) ?>"><br><br>

    <label for="username">Brukernavn:</label><br>
    <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>"><br><br>

    <input type="submit" name="registrer" value="Registrer">
</form>
</body>
</html>
