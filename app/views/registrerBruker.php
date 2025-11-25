<!DOCTYPE html>
<html lang="no">
<head>
    <?php

$navn  = $_POST['navn']  ?? '';
$mobil = $_POST['mobil'] ?? '';
$epost = $_POST['epost'] ?? '';


$feil = $feil ?? [];
?>
    <meta charset="UTF-8">
    <title>Registrer ny bruker</title>
  <link rel="stylesheet" href="../../public/css/registrerBruker.css">
</head>
<body>
    <h1>Registrer ny bruker</h1>

    <?php if (!empty($feil)): ?>
        <ul style="color:red;">
            <?php foreach ($feil as $melding): ?>
                <li><?= htmlspecialchars($melding) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="">
        <label for="navn">Navn:</label><br>
        <input type="text" id="navn" name="navn" value="<?= htmlspecialchars($navn) ?>"><br><br>

        <label for="mobil">Mobilnummer:</label><br>
        <input type="text" id="mobil" name="mobil" value="<?= htmlspecialchars($mobil) ?>"><br><br>

        <label for="epost">E-post:</label><br>
        <input type="text" id="epost" name="epost" value="<?= htmlspecialchars($epost) ?>"><br><br>

        <input type="submit" value="Registrer">
    </form>
</body>
</html>
