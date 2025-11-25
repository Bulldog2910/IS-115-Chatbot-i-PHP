<?php 
session_start();

// Chescks if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../app/views/login.php");
    exit();
}
// Handles logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../app/views/login.php");
    exit();
}
// Get values from session if they exist
$message = $_SESSION['message'] ?? '';
$output = $_SESSION['output'] ?? '';
$error = $_SESSION['error'] ?? [];

// Clear session values after displaying
unset($_SESSION['message'], $_SESSION['output'], $_SESSION['error']);
include __DIR__ . '/../app/views/_header.php';

// Includes code from db.php to start connection to database
include __DIR__ . '/../app/config/db.php';
include __DIR__ . '/../app/controllers/dbController.php';
mysqli_close($conn);
?>

<!-- <div class="chatty">
   <h1 id="overskrift">Chatbot</h1>

   <div class="user-info">
      <?php 
      // Display logged-in user email (or 'Unknown' if not set).
      // htmlspecialchars prevents XSS attacks by escaping special characters.
      ?>
      <span>Logget inn som: <?php echo htmlspecialchars($_SESSION['user_email'] ?? 'Ukjent'); ?></span>

      <?php 
      // Logout form: sends POST request when user clicks "Logg ut"
      ?>
      <form method="POST" style="display: inline;">
         <input type="submit" name="logout" class="button" value="Logg ut">
      </form>
   </div>

   <?php 
   // Main chatbot form: sends user input to ProcessController.php
   ?>
   <form method="POST" action="../app/controllers/ProcessController.php">
      // Input field for user message
      Fornavn: <input type="text" name="message" placeholder="Skriv her..." 
                      value="<?php echo htmlspecialchars($message); ?>"><br>

      <?php 
      // Display error message if validation failed
      if (isset($error['Message'])): ?>
         <span style="color: red;"><?php echo $error['Message']; ?></span><br>
      <?php endif; ?>

      // Display chatbot output
      Output : <output><?php echo htmlspecialchars($output); ?></output><br>

      // Submit button to send the message
      <input type="submit" name="Send" value="Send">
   </form>
</div> -->

// Links 
<?php include '../app/views/chatbotView.php';?>

<a class="button" href="../app/views/userCreation.php">User creation</a>
<a class="button" href="../app/controllers/chatbotControllerTest.php">chatbotTest</a>
<a class="button" href="../app/views/admin.php">admin</a>

// Include footer file
<?php include '../app/views/_footer.php';?>