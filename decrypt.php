<?php

declare(strict_types=1);

require __DIR__ . '/src/Cipher.php';
require __DIR__ . '/src/SecretStorage.php';

use AlphaCryptor\Cipher;
use AlphaCryptor\SecretStorage;

$storage = new SecretStorage(__DIR__ . '/secret.php');

try {
    $mapping = $storage->load();
} catch (\RuntimeException $exception) {
    $stream = defined('STDERR') ? STDERR : fopen('php://stderr', 'w');
    fwrite($stream, "Unable to read the secret mapping. Generate one via parse.php first.\n");
    if (!defined('STDERR')) {
        fclose($stream);
    }
    exit(1);
}

$cipher = new Cipher($mapping);
$defaultCipherText = 'RtwtRw-QRtQtR';

if (PHP_SAPI === 'cli') {
    if (isset($argv[1]) && $argv[1] === '--help') {
        fwrite(STDOUT, "Usage: php decrypt.php [cipher-text]\n");
        fwrite(STDOUT, "Provide an encrypted string to decode. Without an argument a sample value is used.\n");
        exit(0);
    }

    $cipherText = $argv[1] ?? $defaultCipherText;
    echo $cipher->decrypt($cipherText) . PHP_EOL;
    return;
}

echo $cipher->decrypt($defaultCipherText);
