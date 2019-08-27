<?php

namespace devsergeev\validators;

use InvalidArgumentException;

class InnValidator
{
    public const CODE_INVALID_LENGHT   = 1;
    public const CODE_NOT_ONLY_DIGITS  = 2;
    public const CODE_INVALID_CHECKSUM = 3;

    public static $messageInvalidLenght   = 'ИНН должен иметь длину 10 (физлицо) или 12 (юрлицо) символов';
    public static $messageOnlyDigits      = 'ИНН должен состоять только из цифр';
    public static $messageInvalidChecksum = 'ИНН недействителен (неверная контрольная сумма)';

    public static function check(string $inn): bool
    {
        $innSymbols = str_split($inn);
        $innLenght = mb_strlen($inn);
        if ($innLenght === 10) {
            self::checkInnSymbols($inn, $innLenght);
            self::checkChecksum($innSymbols, 9);
        } else if ($innLenght === 12) {
            self::checkInnSymbols($inn, $innLenght);
            self::checkChecksum($innSymbols, 10);
            self::checkChecksum($innSymbols, 11);
        } else {
            throw new InvalidArgumentException((string) self::$messageInvalidLenght, self::CODE_INVALID_LENGHT);
        }
        return true;
    }

    private static function checkChecksum(array $innSymbols, int $checkInnIndex): void
    {
        $checksum = 0;
        $offset = 11 - $checkInnIndex;
        $coefficients = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8];
        for ($innIndex = 0; isset($coefficients[$innIndex + $offset]); $innIndex++) {
            $checksum += (int) $innSymbols[$innIndex] * $coefficients[$innIndex + $offset];
        }
        if ((int)$innSymbols[$checkInnIndex] !== $checksum % 11 % 10) {
            throw new InvalidArgumentException((string) self::$messageInvalidChecksum, self::CODE_INVALID_CHECKSUM);
        }
    }

    private static function checkInnSymbols(string $inn, int $innLenght): void
    {
        for ($innIndex = 0; $innIndex < $innLenght; $innIndex++) {
            if (!is_numeric($inn[$innIndex])) {
                throw new InvalidArgumentException((string) self::$messageOnlyDigits, self::CODE_NOT_ONLY_DIGITS);
            }
        }
    }
}
