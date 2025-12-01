<?php $page = $_GET['page'] ?? 'questions'; // default view?>
<link rel="stylesheet" href="./CSS/admin.css">

<nav class="admin-nav">
    <a href="./Index.php">home</a>
    <a class="<?= $page === 'questions' ? 'active' : '' ?>" href="?page=questions">Questions</a>
    <a class="<?= $page === 'keywords' ? 'active' : '' ?>" href="?page=keywords">Keywords</a>
    <a class="<?= $page === 'users' ? 'active' : '' ?>" href="?page=users">Users</a>
</nav>
<?php
switch ($page) {
    case 'questions':
        include __DIR__ . '/editQuestions.view.php';
        break;

    case 'keywords':
        include __DIR__ . '/editKeywords.view.php';
        break;

    case 'users':
        include __DIR__ . '/editUsers.view.php';
        break;

    default:
        echo "<p>Invalid page.</p>";
}
?>
