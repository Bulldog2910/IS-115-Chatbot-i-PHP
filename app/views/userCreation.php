
<?php
    include __DIR__ . '/_header.php';
    include __DIR__ . '/../controllers/userCreationController.php';
    mysqli_close($conn);
?>
<a href="../../public/Index.php" style="text-decoration: none; width:50px;"><H1 style="background-color: lightblue; border-radius:10px; width: 90px; padding-left:15px;">Hjem</H1></a>

<form name="" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <p class="fnavn"> Fornavn: </p><input  type="text" name="fnavn" placeholder="Fornavn"><br>
  <p class="enavn"> Etternavn:</p> <input  type="text" name="enavn" placeholder="Etternavn"><br>
  <p class="epost" > E-post: </p><input type="text" name="epost" placeholder="E-post"><br>
  <p class="password"> Password: </p><input  type="password" name="password" placeholder="password"><br>
  <p class="username"> Username: </p><input  type="text" name="username" placeholder="username"><br>
  <input type="submit" name="registrer" value="Registrér">
</form>

<?php include './_footer.php';?>
