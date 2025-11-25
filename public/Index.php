<?php 
// Clear session values after displaying
unset($_SESSION['message'], $_SESSION['output'], $_SESSION['error']);
include __DIR__ . '/../app/views/_header.php';

?>

<!-- <div class="chatty">
   <h1 id="overskrift">Chatbot</h1>

   <div class="user-info">
   <span>Logget inn som: <?php echo htmlspecialchars($_SESSION['username']); ?></span>
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
</div> -->


<?php include '../app/views/chatbotView.php';?>

<a class="button" href="../app/views/userCreation.php">User creation</a>
<a class="button" href="../app/controllers/chatbotControllerTest.php">chatbotTest</a>
<a class="button" href="../app/views/admin.php">admin</a>

<?php include '../app/views/_footer.php';?>