<?php 
session_start();

// Sjekk om bruker er logget inn
if (!isset($_SESSION['user_id'])) {
    header("Location: ../app/views/login.php");
    exit();
}
// Håndter logout
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

// includes code from db.php to start connection to database
include __DIR__ . '/../app/config/db.php';
include __DIR__ . '/../app/controllers/dbController.php';
mysqli_close($conn);
?>

<div class="chatty">
   <h1 id="overskrift">Chatbot</h1>

   <div class="user-info">
   <span>Logget inn som: <?php echo htmlspecialchars($_SESSION['user_email'] ?? 'Ukjent'); ?></span>
   <form method="POST" style="display: inline;">
      <input type="submit" name="logout" class="button" value="Logg ut">
   </form>
</div>

   <form method="POST" action="../app/controllers/ProcessController.php">
      Fornavn: <input type="text" name="message" placeholder="Skriv her..." value="<?php echo htmlspecialchars($message); ?>"><br>
      <?php if (isset($error['Message'])): ?>
         <span style="color: red;"><?php echo $error['Message']; ?></span><br>
      <?php endif; ?>
      Output : <output><?php echo htmlspecialchars($output); ?></output><br>
      <input type="submit" name="Send" value="Send">
   </form>
</div>



<a href="../app/views/userCreation.php">User creation</a>
<a href="../app/controllers/chatbotControllerTest.php">chatbotTest</a>

<?php include '../app/views/_footer.php';?>