
<link rel="stylesheet" href="./CSS/admin.css">

<a href="./Index.php" style="text-decoration: none; width:50px;"><H1 style="background-color: lightblue; border-radius:10px; width: 90px; padding-left:15px;">Hjem</H1></a>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
    <input class="button" type="submit" name="identificatorTable" value="Reset Database">
</form>
<?php
    require __DIR__ . '/../../controllers/Admin/adminController.php';
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

<h1>Users</h1>
<table>
    <tr class="tableHead">
        <th>Username:</th>
        <th>First Name:</th>
        <th>Last Name:</th>
        <th>Userpassword:</th>
        <th>Mail:</th>
    </tr>
<?php while ($row = $selectViews->resultChat->fetch_assoc()): ?>
    <tr>
        <td><?= $row['username'] ?></td>
        <td><?= $row['firstName'] ?></td>
        <td><?= $row['lastName'] ?></td>
        <td><?= $row['userpassword'] ?></td>
        <td><?= $row['mail'] ?></td>
    </tr>
<?php endwhile; ?>
</table>

<h1>Keyword</h1>
<table>
    <tr>
        <th>KeywordId:</th>
        <th>Keyword:</th>
        <th></th>
    </tr>
<?php while ($row = $selectViews->resultKey->fetch_assoc()): ?>
    <tr class="tableHead">
        <td><?= $row['keywordId'] ?></td>
        <td><?= $row['keyword'] ?></td>
        
        <td>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>"> 
                <input type="submit" value="Edit"> 
                <input name="identificatorValue" type="hidden" value="<?php echo $row['keyword']?>">
                <input name="identificatorId" type="hidden" value="<?php echo $row['keywordId']?>">
                <input name="identificatorTable" type="hidden" value="keyword">
            </form>
        </td>

    </tr>
<?php endwhile; ?>
</table>


