
<?php
session_start();

// Sjekk om bruker er logget inn
if (!isset($_SESSION['user_id'])) {
    header("Location: ../app/views/login.php");
    exit();
}

include '../app/views/_header.php';
include '../app/controllers/dbController.php';

// Håndter logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../app/views/login.php");
    exit();
}
?>

<div class="chatty">
   <h1 id="overskrift">Chatbot</h1>
   <div class="user-info">
   <span>Logget inn som: <?php echo htmlspecialchars($_SESSION['user_email'] ?? 'Ukjent'); ?></span>
   <form method="POST" style="display: inline;">
      <input type="submit" name="logout" class="button" value="Logg ut">
   </form>
</div>
   <form method="POST">
      <input type="submit" name="createdb" class="button" value="Create database"/>
   </form>
   <form method="POST" action="">
      <input type="text" placeholder="Skriv din melding her..." name="user_input" required> <br>
         <input type="submit" name="send_message" value="Send melding" class="button">
      <br> <br>
      <div class="output-field">
         <textarea id="chat_output" name="chat_output" readonly rows="4" cols="50" placeholder="Chatbotens svar vil vises her..."><?php echo isset($_SESSION['chat_response']) ? $_SESSION['chat_response'] : ''; ?></textarea>
      </div>
   </form>
</div>


<?php include '../app/views/_footer.php';?>