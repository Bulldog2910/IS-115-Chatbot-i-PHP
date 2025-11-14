<?php
require_once "../controllers/LoginController.php";
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
</div>

<?php include '_footer.php'; ?>