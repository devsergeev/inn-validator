<?php

namespace devsergeev\validators;

use InvalidArgumentException;

class InnValidator
{
    public const MESSAGE_INVALID_LENGHT   = 'ИНН должен иметь длину 10 (физлицо) или 12 (юрлицо) символов';
    public const MESSAGE_INVALID_CHECKSUM = 'ИНН не действителен (не правильная контрольная сумма)';
    public const MESSAGE_NOT_ONLY_DIGITS  = 'ИНН должен состоять только из цифр';

    public static function check(string $inn): bool
    {
        $innSymbols = str_split($inn);
        $innLenght = mb_strlen($inn);
        if ($innLenght === 10) {
            self::checkInnSymbols($inn, $innLenght);
            self::checkChecksum($innSymbols, 9, 2);
        } else if ($innLenght === 12) {
            self::checkInnSymbols($inn, $innLenght);
            self::checkChecksum($innSymbols, 10, 1);
            self::checkChecksum($innSymbols, 11, 0);
        } else {
            throw new InvalidArgumentException(self::MESSAGE_INVALID_LENGHT);
        }
        return true;
    }

    private static function checkChecksum(array $innSymbols, int $checkInnIndex, int $offset): void
    {
        $checksum = 0;
        $coefficients = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8];
        for ($innIndex = 0; isset($coefficients[$innIndex + $offset]); $innIndex++) {
            $checksum += (int)$innSymbols[$innIndex] * $coefficients[$innIndex + $offset];
        }
        if ((int)$innSymbols[$checkInnIndex] !== $checksum % 11 % 10) {
            throw new InvalidArgumentException(self::MESSAGE_INVALID_CHECKSUM);
        }
    }

    private static function checkInnSymbols(string $inn, int $innLenght): void
    {
        for ($innIndex = 0; $innIndex < $innLenght; $innIndex++) {
            if (!is_numeric($inn[$innIndex])) {
                throw new InvalidArgumentException(self::MESSAGE_NOT_ONLY_DIGITS);
            }
        }
    }
}
