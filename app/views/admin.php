
<style>
    th, td, tr, table {
        border: black solid 2px;
    }
</style>
<a href="../../public/Index.php" style="text-decoration: none; width:50px;"><H1 style="background-color: lightblue; border-radius:10px; width: 90px; padding-left:15px;">Hjem</H1></a>
<?php
    include_once '_header.php';

    // Sjekker at innlogget bruker har admin-rolle, ellers nektes tilgang
    if ($_SESSION['role'] !== 'admin') {
        header("Location: index.php?feil=Ikke_tilgang.");
        exit;
    }
?>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['identificatorTable'] == 'keyword'){
include __DIR__ . '/admin/keywordForm.php';
    
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include __DIR__ . '/../config/db.php';


$conn->select_db('FAQUiaChatbot');
$stmt = $conn->prepare('SELECT * FROM questions');
$stmt->execute();
$resultQ = $stmt->get_result();

$stmt = $conn->prepare('SELECT * FROM chatUser');
$stmt->execute();
$resultChat = $stmt->get_result();

$stmt = $conn->prepare('SELECT * FROM keyWords');
$stmt->execute();
$resultKey = $stmt->get_result();

?>
<h1>Questions</h1>
<table>
    <tr>
        <th>Question:</th>
        <th>Keyword1:</th>
        <th>Keyword2:</th>
        <th>Keyword3:</th>
        <th>Category:</th>
    </tr>
<?php while ($row = $resultQ->fetch_assoc()): ?>
    <tr>
        <td><?= $row['questionDescription'] ?></td>
        <td><?= $row['keyword1'] ?></td>
        <td><?= $row['keyword2'] ?></td>
        <td><?= $row['keyword3'] ?></td>
        <td><?= $row['category'] ?></td>
    </tr>
<?php endwhile; ?>
</table>

<h1>Users</h1>
<table>
    <tr>
        <th>Username:</th>
        <th>First Name:</th>
        <th>Last Name:</th>
        <th>Userpassword:</th>
        <th>Mail:</th>
    </tr>
<?php while ($row = $resultChat->fetch_assoc()): ?>
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
    </tr>
<?php while ($row = $resultKey->fetch_assoc()): ?>
    <tr>
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


