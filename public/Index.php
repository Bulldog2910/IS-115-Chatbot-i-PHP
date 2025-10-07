
<?php include '../app/views/_header.php';?>
<?php include '../app/controllers/dbController.php';?>

<div class="chatty">
   <h1 id="overskrift">Chatbot</h1>
   <form method="POST">
      <input type="submit" name="createdb" class="button" value="Create database"/>
   </form>
   <form action="">
      Input : <input type="text" placeholder="Elias har liten tiss" name="" id=""> <br>
      Output : <output placeholder="Output"></output>
   </form>
</div>


<?php include '../app/views/_footer.php';?>