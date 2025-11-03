
<?php 

include __DIR__ . '/../app/views/_header.php';

// includes code from db.php to start connection to database
include __DIR__ . '/../app/config/db.php';
include __DIR__ . '/../app/controllers/dbController.php';
mysqli_close($conn);?>

<div class="chatty">
   <h1 id="overskrift">Chatbot</h1>
   <form method="POST" action="">
      <input type="text" placeholder="Skriv din melding her..." name="user_input" required> <br>
         <input type="submit" name="send_message" value="Send melding" class="button">
      <br> <br>
      <div class="output-field">
         <textarea id="chat_output" name="chat_output" readonly rows="4" cols="50" placeholder="Chatbotens svar vil vises her..."><?php echo isset($_SESSION['chat_response']) ? $_SESSION['chat_response'] : ''; ?></textarea>
      </div>
   </form>
</div>

<a href="../app//views/userCreation.php">User creation</a>


<?php include '../app/views/_footer.php';?>