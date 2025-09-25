<?php

declare(strict_types=1);

require __DIR__ . '/src/Alphabet.php';
require __DIR__ . '/src/Cipher.php';
require __DIR__ . '/src/SecretStorage.php';

use AlphaCryptor\Alphabet;
use AlphaCryptor\Cipher;
use AlphaCryptor\SecretStorage;

$storage = new SecretStorage(__DIR__ . '/secret.php');

$input = $_POST['string'] ?? '';
$error = null;
$result = '';
$notices = [];

try {
    $mapping = $storage->load();
} catch (\RuntimeException $exception) {
    $mapping = $storage->regenerate(Alphabet::CHARACTERS);
    $notices[] = 'The previous secret mapping was unavailable, so a new one has been generated.';
}

if (isset($_GET['regenerate']) && $_GET['regenerate'] === '1') {
    $mapping = $storage->regenerate(Alphabet::CHARACTERS);
    $notices[] = 'Generated a fresh substitution alphabet.';
}

$cipher = new Cipher($mapping);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($input === '') {
        $error = 'Please enter a string to encrypt.';
    } elseif (mb_strlen($input) > 125) {
        $error = 'Input must be 125 characters or fewer.';
    } else {
        $result = $cipher->encrypt($input);
        $notices[] = 'Successfully encrypted your input.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Alpha Cryptor</title>
</head>
<body>
<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="mb-0">Alpha Cryptor</h1>
        <a href="?regenerate=1" class="btn btn-outline-secondary">Regenerate Secret</a>
    </div>

    <?php foreach ($notices as $notice): ?>
        <div class="alert alert-info" role="alert">
            <?php echo htmlspecialchars($notice, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endforeach; ?>

    <?php if ($error !== null): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <?php if ($result !== ''): ?>
        <div class="alert alert-success" role="alert">
            <strong>Encrypted output:</strong>
            <pre class="mb-0"><?php echo htmlspecialchars($result, ENT_QUOTES, 'UTF-8'); ?></pre>
        </div>
    <?php endif; ?>

    <form action="" method="post" class="card card-body shadow-sm">
        <div class="form-group">
            <label for="stringLabel">String to encrypt</label>
            <input type="text" class="form-control" id="stringLabel" name="string" value="<?php echo htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); ?>" maxlength="125" autocomplete="off">
            <small class="form-text text-muted">Maximum length: 125 characters. The same secret is reused until you regenerate it.</small>
        </div>
        <button type="submit" class="btn btn-primary">Encrypt</button>
    </form>
</div>
</body>
</html>
