<?php

// $error       = array of error messages
// $successMsg  = success string
// $data        = form values: firstName, lastName, username, mail, userpassword, repeatpassword
?>
<link rel="stylesheet" href="./CSS/registrerUser.css">

<h1>Registrer ny bruker</h1>

<?php if (!empty($error)): ?>
    <ul style="color:red;">
        <?php foreach ($error as $msg): ?>
            <li><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (!empty($successMsg)): ?>
    <p style="color:green;"><?= htmlspecialchars($successMsg, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<form method="post" action="">
    <label for="firstName">Fornavn:</label><br>
    <input type="text" id="firstName" name="firstName"
           value="<?= htmlspecialchars($data['firstName'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="lastName">Etternavn:</label><br>
    <input type="text" id="lastName" name="lastName"
           value="<?= htmlspecialchars($data['lastName'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="username">Brukernavn:</label><br>
    <input type="text" id="username" name="username"
           value="<?= htmlspecialchars($data['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="userpassword">Passord:</label><br>
    <input type="password" id="userpassword" name="userpassword"
           value="<?= htmlspecialchars($data['userpassword'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="repeatpassword">Gjenta passord:</label><br>
    <input type="password" id="repeatpassword" name="repeatpassword"
           value="<?= htmlspecialchars($data['repeatpassword'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="mail">E-post:</label><br>
    <input type="text" id="mail" name="mail"
           value="<?= htmlspecialchars($data['mail'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <input type="submit" name="registrer" value="Registrer">
</form>
