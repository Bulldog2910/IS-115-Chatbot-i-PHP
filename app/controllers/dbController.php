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