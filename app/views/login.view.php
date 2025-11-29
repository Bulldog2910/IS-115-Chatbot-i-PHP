<?php
    include __DIR__ . '/shared/_header.php';
?>
<link rel="stylesheet" href="../public/css/login.css">

<div class="login-container">
    <h2>Logg inn</h2>

    <?php if (!empty($errorMsg)): ?>
        <div class="error-messages">
            <ul style="color:red;">
                <?php foreach ($errorMsg as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="email">E-post:</label>
            <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Din e-post">
        </div>

        <div class="form-group">
            <label for="password">Passord:</label>
            <input type="password" id="password" name="password" required placeholder="Passord">
        </div>

        <button type="submit" name="login" class="button">Logg inn</button>
    </form>

    <a href="registerUser.php">
        <button class="button" type="button">Registrér</button>
    </a>
</div>

<?php include __DIR__ . '/shared/_footer.php'; ?>
