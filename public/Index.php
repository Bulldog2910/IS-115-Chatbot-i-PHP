<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Index</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="./CSS/Index.css">
<body>
   <?php include '../app/controllers/dbController.php';?>

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
