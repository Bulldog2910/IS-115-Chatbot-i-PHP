<?php 
session_start();

// Get values from session if they exist
$message = $_SESSION['message'] ?? '';
$output = $_SESSION['output'] ?? '';
$error = $_SESSION['error'] ?? [];

// Clear session values after displaying
unset($_SESSION['message'], $_SESSION['output'], $_SESSION['error']);

include '../app/views/_header.php';
include '../app/controllers/dbController.php';
include '../app/controllers/chatbotController.php';
?>

<div class="chatty">
   <h1 id="overskrift">Chatbot</h1>
   <form method="POST" action="../app/controllers/ProcessController.php">
      <input type="submit" name="createdb" class="button" value="Create database"/>
   </form>

   <form method="POST" action="../app/controllers/ProcessController.php">
      Fornavn: <input type="text" name="message" placeholder="Skriv her..." value="<?php echo htmlspecialchars($message); ?>"><br>
      <?php if (isset($error['Message'])): ?>
         <span style="color: red;"><?php echo $error['Message']; ?></span><br>
      <?php endif; ?>
      Output : <output><?php echo htmlspecialchars($output); ?></output><br>
      <input type="submit" name="Send" value="Send">
   </form>
</div>

<?php include '../app/views/_footer.php';?>