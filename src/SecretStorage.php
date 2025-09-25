<?php

declare(strict_types=1);

namespace AlphaCryptor;

use RuntimeException;

/**
 * Persists and retrieves cipher mappings from disk.
 */
final class SecretStorage
{
    public function __construct(private readonly string $filePath)
    {
    }

    /**
     * @return array<string, string>
     */
    public function load(): array
    {
        if (!is_file($this->filePath)) {
            throw new RuntimeException('Secret file not found.');
        }

        $mapping = require $this->filePath;
        if (!is_array($mapping)) {
            throw new RuntimeException('Secret file must return an array.');
        }

        return $mapping;
    }

    /**
     * @param array<string, string> $mapping
     */
    public function save(array $mapping): void
    {
        $php = "<?php\nreturn " . var_export($mapping, true) . ";\n";

        if (false === file_put_contents($this->filePath, $php)) {
            throw new RuntimeException('Unable to write secret file.');
        }
    }

    /**
     * @param list<string> $alphabet
     * @return array<string, string>
     */
    public function regenerate(array $alphabet): array
    {
        $shuffled = $alphabet;
        shuffle($shuffled);

        $mapping = array_combine($alphabet, $shuffled);
        if ($mapping === false) {
            throw new RuntimeException('Failed to generate cipher mapping.');
        }

        $this->save($mapping);

        return $mapping;
    }
}
