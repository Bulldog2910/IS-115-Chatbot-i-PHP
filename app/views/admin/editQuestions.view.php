
<!-- <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
    <input class="button" type="submit" name="identificatorTable" value="Reset Database">
</form> -->
<?php
    $_SESSION['chatbotLog'] = [];
?>
<h1>Questions</h1>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>"> 
    <input type="hidden" name="identificatorTable" value="question">
    <input type="hidden" name="identificatorQ" value="addQ">
    <input type="submit" value="Add question">
</form>
    
<table>
    <tr class="tableHead">
        <th>Question:</th>
        <th>Answer:</th>
        <th>Keyword1:</th>
        <th>Keyword2:</th>
        <th>Keyword3:</th>
        <th>Keyword4:</th>
        <th>Keyword5:</th>
        <th>Keyword6:</th>
        <th>Keyword7:</th>
        <th>Keyword8:</th>
        <th>Keyword9:</th>
        <th>Keyword10:</th>
        <th></th>

    </tr>
<?php while ($row = $selectViews->resultQ->fetch_assoc()): ?>
    <tr >
        <td><?= $row['questionDescription'] ?></td>
        <td><?= $row['questionAnswer'] ?></td>
        <td><?= $row['keyword1'] ?></td>
        <td><?= $row['keyword2'] ?></td>
        <td><?= $row['keyword3'] ?></td>
        <td><?= $row['keyword4'] ?></td>
        <td><?= $row['keyword5'] ?></td>
        <td><?= $row['keyword6'] ?></td>
        <td><?= $row['keyword7'] ?></td>
        <td><?= $row['keyword8'] ?></td>
        <td><?= $row['keyword9'] ?></td>
        <td><?= $row['keyword10'] ?></td>
        <td>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>"> 
                <input type="submit" value="Edit"> 
                <?php
                    $fields = ['questionDescription', 'questionAnswer'];
                    for ($i = 1; $i <= 10; $i++) {
                        $fields[] = "keyword$i";
                    }

                    foreach ($fields as $field) {
                        echo '<input type="hidden" name="'.$field.'" value="'.$row[$field].'">';
                    }
                ?>
                <input name="identificatorId" type="hidden" value="<?php echo $row['questionId']?>">
                <input name="identificatorTable" type="hidden" value="question">
                <input type="hidden" name="identificatorQ" value="editQ">
            </form>
        </td>
    </tr>
<?php endwhile; ?>
</table>
