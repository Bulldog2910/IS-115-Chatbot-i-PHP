
<?php include '../app/views/_header.php';?>
<?php include '../app/controllers/dbController.php';?>

<div class="chatty">
   <h1 id="overskrift">Chatbot</h1>
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