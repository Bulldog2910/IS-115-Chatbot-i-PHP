<link rel="stylesheet" href="./CSS/admin.css">

<nav class="admin-nav">
    <a href="./Index.php">home</a>
    <a href="?page=questions">Questions</a>
    <a href="?page=keywords">Keywords</a>
    <a href="?page=users">Users</a>
</nav>

<?php
$page = $_GET['page'] ?? 'questions'; // default view

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


