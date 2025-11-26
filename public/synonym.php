<?php 
require_once __DIR__ . '/../app/controllers/synonymController.php';

$controller = new ChatbotController();
list($userMessage, $botReply, $results, $synonyms, $error) = $controller->handleQuestion();
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Chatbot</title>
</head>
<body style="font-family: Arial; padding: 40px;">

    <h2>Chatbot</h2>

    <form method="POST" action="">
        <input 
            type="text" 
            name="question" 
            placeholder="Skriv et spørsmål…" 
            style="padding: 8px; width: 300px;" 
            required
        >
        <button type="submit" style="padding: 8px 16px;">Send</button>
    </form>

    <hr style="margin: 20px 0;">

    <?php if (!empty($error)): ?>
        <p style="color:red;"><strong>Feil:</strong> <?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (!empty($botReply)): ?>
        <p><strong>Bot:</strong> <?= htmlspecialchars($botReply) ?></p>
    <?php endif; ?>

    <?php if (!empty($synonyms)): ?>
    <h3>Synonymer</h3>

    <?php foreach ($synonyms as $word => $list): ?>
        <?php if (!empty($list)): ?>
            <p>
                <strong><?= htmlspecialchars($word) ?>:</strong>
                <?= htmlspecialchars(implode(', ', $list)) ?>
            </p>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

</body> 
</html>
