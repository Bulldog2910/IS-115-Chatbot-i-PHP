<?php
// Include the shared header file
include __DIR__ . '/shared/_header.php';
?>

<?php
// Load CSS stylesheet for login page
?>
<link rel="stylesheet" href="../public/css/login.css">

<div class="login-container">
    <h2>Log in</h2>

    <?php if (!empty($errorMsg)): ?>
        <?php
        // If there are error messages, display them in red
        ?>
        <div class="error-messages">
            <ul style="color:red;">
                <?php foreach ($errorMsg as $error): ?>
                    <?php
                    // Escape each error message to prevent XSS
                    ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php
    // Login form
    ?>
    <form method="POST" action="">
        <div class="form-group">
            <?php
            // Input field for email
            ?>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required 
                   value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" 
                   placeholder="Your e-mail">
        </div>

        <div class="form-group">
            <?php
            // Input field for password 
            ?>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required placeholder="Passord">
        </div>

        <?php
        // Submit button for login
        ?>
        <button type="submit" name="login" class="button">Log in</button>
    </form>

    <?php
    // Link to registration page with button
    ?>
    <a href="registerUser.php">
        <button class="button" type="button">Register</button>
    </a>
</div>

<?php
// Include the shared footer file
include __DIR__ . '/shared/_footer.php';
?>