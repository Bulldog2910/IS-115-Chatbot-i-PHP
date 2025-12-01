<?php
// Form that registers a new user
// $successMsg  = success string
// $data        = form values: firstName, lastName, username, mail, userpassword, repeatpassword
?>

<?php
// Load CSS stylesheet
?>
<link rel="stylesheet" href="./CSS/registrerUser.css">

<h1>Register new user</h1>

<?php if (!empty($error)): ?>
    <?php
    // Show error messages in red
    ?>
    <ul style="color:red;">
        <?php foreach ($error as $msg): ?>
            <li><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (!empty($successMsg)): ?>
    <?php
    // Show success message in green
    ?>
    <p style="color:green;"><?= htmlspecialchars($successMsg, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<?php
// Registration form
?>
<form method="post" action="">
    <label for="firstName">First name:</label><br>
    <input type="text" id="firstName" name="firstName"
           value="<?= htmlspecialchars($data['firstName'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="lastName">Last name:</label><br>
    <input type="text" id="lastName" name="lastName"
           value="<?= htmlspecialchars($data['lastName'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username"
           value="<?= htmlspecialchars($data['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="userpassword">Password:</label><br>
    <input type="password" id="userpassword" name="userpassword"
           value="<?= htmlspecialchars($data['userpassword'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="repeatpassword">Repeat password:</label><br>
    <input type="password" id="repeatpassword" name="repeatpassword"
           value="<?= htmlspecialchars($data['repeatpassword'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="mail">e-mail:</label><br>
    <input type="text" id="mail" name="mail"
           value="<?= htmlspecialchars($data['mail'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <?php
    // Submit button
    ?>
    <input type="submit" name="register" value="Register">
</form>