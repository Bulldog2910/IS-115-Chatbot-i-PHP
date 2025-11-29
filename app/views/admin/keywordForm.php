
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
    <?= $_POST['identificatorId']?> 
    <input type="text" name="identificatorValue" value="<?= $_POST['identificatorValue']?>"> 
    <input type="hidden" name="identificatorTable" value="keyword"> 
    <input type="hidden" name="identificator" value="keywordUpdate"> 
    <input type="hidden" name="identificatorId" value="<?= $_POST['identificatorId']?>"> 
    <input type="submit">
</form>