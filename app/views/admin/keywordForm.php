<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
    <input type="text" name="keywordId" value="<?= $_POST['identificatorId'] ?>"> 
    <input type="text" name="keyword" value="<?= $_POST['identificatorValue'] ?>"> 
    <input type="submit">
</form>