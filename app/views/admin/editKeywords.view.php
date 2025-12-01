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