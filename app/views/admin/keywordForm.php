
<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'])?>" method="POST">
    <?= $_POST['identificatorId']?> 
    <input type="text" name="identificatorValue" value="<?= $_POST['identificatorValue']?>"> 
    <input type="hidden" name="identificatorTable" value="keyword"> 
    <input type="hidden" name="identificator" value="keywordUpdate"> 
    <input type="hidden" name="identificatorId" value="<?= $_POST['identificatorId']?>"> 
    <input type="submit">
</form>