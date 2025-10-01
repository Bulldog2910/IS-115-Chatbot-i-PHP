<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Index</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="./CSS/Index.css">
<body>
   <?php
   if(array_key_exists('createdb', $_POST)) {
            createdb();
        }
   function createdb(){
      // includes code from db.php to start connection to database
      include '../app/config/db.php';
      
      // Read schema.sql and run
      $sqlPath = "../app/database/schema.sql";
      $sql = file_get_contents($sqlPath);
      if (mysqli_multi_query($conn, $sql)) {
      echo "<br>Tables created successfully";
      } else {
      echo "Error creating table: " . mysqli_error($conn);
      }
      // close connection to database
      mysqli_close($conn);
   }
      ?>

<div class="chatty">
 <h1 id="overskrift">Chatbot</h1>
 <form method="POST">
      <input type="submit" name="createdb"
                class="button" value="Create database"/>
   </form>
   <br>
 <form action="">
    Input : <input type="text" placeholder="Elias har liten tiss" name="" id=""> <br>
    Output : <output placeholder="Output"></output>
    
 </form>
</div>

</body>
</html>
