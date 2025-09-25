<?php

declare(strict_types=1);

namespace AlphaCryptor;

use InvalidArgumentException;

/**
 * Handles encryption and decryption for the substitution cipher.
 */
final class Cipher
{
    /**
     * @var array<string, string>
     */
    private array $mapping;

    /**
     * @var array<string, string>
     */
    private array $reverseMapping;

    public function __construct(array $mapping)
    {
        $this->mapping = $this->normalizeMapping($mapping);
        $this->reverseMapping = array_flip($this->mapping);

        if (count($this->mapping) !== count($this->reverseMapping)) {
            throw new InvalidArgumentException('The cipher mapping must contain unique values.');
        }
    }

    public function encrypt(string $plainText): string
    {
        return $this->transform($plainText, $this->mapping);
    }

    public function decrypt(string $cipherText): string
    {
        return $this->transform($cipherText, $this->reverseMapping);
    }

    /**
     * @param array<string, string> $mapping
     */
    private function transform(string $input, array $mapping): string
    {
        $characters = preg_split('//u', $input, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        $result = '';
        foreach ($characters as $character) {
            $result .= $mapping[$character] ?? $character;
        }

        return $result;
    }

    private function normalizeMapping(array $mapping): array
    {
        if ($mapping === []) {
            throw new InvalidArgumentException('The cipher mapping cannot be empty.');
        }

        $normalized = [];

        foreach ($mapping as $key => $value) {
            if (!is_scalar($key) || !is_scalar($value)) {
                throw new InvalidArgumentException('The cipher mapping must contain only scalar values.');
            }

            $keyString = (string) $key;
            $valueString = (string) $value;

            if ($keyString === '' || $valueString === '') {
                throw new InvalidArgumentException('The cipher mapping may not contain empty strings.');
            }

            if (array_key_exists($keyString, $normalized)) {
                throw new InvalidArgumentException('Duplicate keys detected in the cipher mapping.');
            }

            $normalized[$keyString] = $valueString;
        }

        return $normalized;
    }
}
