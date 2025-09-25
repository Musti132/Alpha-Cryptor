<?php

declare(strict_types=1);

namespace AlphaCryptor;

/**
 * Provides the character set used for the substitution cipher.
 */
final class Alphabet
{
    /**
     * Ordered list of supported characters for encryption and decryption.
     */
    public const CHARACTERS = [
        'a',
        'b',
        'c',
        'd',
        'e',
        'f',
        'g',
        'h',
        'i',
        'j',
        'k',
        'l',
        'm',
        'n',
        'o',
        'p',
        'q',
        'r',
        's',
        't',
        'u',
        'v',
        'w',
        'x',
        'y',
        'z',
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z',
        '!',
        '#',
        '_',
        '-',
        ' ',
        '.',
        ',',
        ':',
        ';',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '0',
        '$',
        '~',
        '^',
        ')',
        '?',
        ']',
        "'",
        '*',
    ];

    private function __construct()
    {
    }
}
