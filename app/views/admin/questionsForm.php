
<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>"> 
    
    ID: <?php echo $_POST['identificatorId'] ?? "" ?> <input type="hidden" name="identificatorId" value="<?php echo $_POST['identificatorId'] ?? "" ?? $addQ->Qid ?>"><br>
    Question description: <input name="questionDescription" type="text" value="<?php echo $_POST['questionDescription'] ?? ""?>"><br>
    Answer description: <input name="questionAnswer" type="text" value="<?php echo $_POST['questionAnswer'] ?? ""?>"><br>
    Keyword 1: <input name="keyword1" type="text" value="<?php echo $_POST['keyword1'] ?? ""?>"><br>
    Keyword 2: <input name="keyword2" type="text" value="<?php echo $_POST['keyword2'] ?? ""?>"><br>
    Keyword 3: <input name="keyword3" type="text" value="<?php echo $_POST['keyword3'] ?? ""?>"><br>
    Keyword 4: <input name="keyword4" type="text" value="<?php echo $_POST['keyword4'] ?? ""?>"><br>
    Keyword 5: <input name="keyword5" type="text" value="<?php echo $_POST['keyword5'] ?? ""?>"><br>
    Keyword 6: <input name="keyword6" type="text" value="<?php echo $_POST['keyword6'] ?? ""?>"><br>
    Keyword 7: <input name="keyword7" type="text" value="<?php echo $_POST['keyword7'] ?? ""?>"><br>
    Keyword 8: <input name="keyword8" type="text" value="<?php echo $_POST['keyword8'] ?? ""?>"><br>
    Keyword 9: <input name="keyword9" type="text" value="<?php echo $_POST['keyword9'] ?? ""?>"><br>
    Keyword 10: <input name="keyword10" type="text" value="<?php echo $_POST['keyword10'] ?? ""?>"><br>

    <input name="identificatorTable" type="hidden" value="question">
    <input type="submit" name="Qtype" value="addQ"> 
    <input type="submit" name="Qtype" value="editQ">          
    <?php echo $_POST['identificatorQ'] ?? ""?>      
</form>