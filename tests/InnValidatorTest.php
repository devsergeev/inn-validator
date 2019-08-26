<?php

namespace devsergeev\validators\tests;

use PHPUnit\Framework\TestCase;
use devsergeev\validators\InnValidator;
use InvalidArgumentException;

class InnValidatorTest extends TestCase
{
    /**
     * @dataProvider provideValidInn
     * @param string $inn
     */
    public function testCheckValid(string $inn): void
    {
        $this->assertTrue(InnValidator::check($inn));
    }

    /**
     * @dataProvider provideInnWithInvalidControlsum
     * @param string $inn
     */
    public function testCheckInvalidControlsum(string $inn): void
    {
        $this->expectExceptionWithMessage(InnValidator::MESSAGE_INVALID_CHECKSUM);
        InnValidator::check($inn);
    }

    /**
     * @dataProvider provideInnWithInvalidLenght
     * @param string $inn
     */
    public function testCheckInvalidLenght(string $inn): void
    {
        $this->expectExceptionWithMessage(InnValidator::MESSAGE_INVALID_LENGHT);
        InnValidator::check($inn);
    }

    /**
     * @dataProvider provideInnWithNotOnlyDigits
     * @param string $inn
     */
    public function testCheckInnWithNotOnlyDigits(string $inn): void
    {
        $this->expectExceptionWithMessage(InnValidator::MESSAGE_NOT_ONLY_DIGITS);
        InnValidator::check($inn);
    }

    public function provideValidInn(): array
    {
        return [['3329000313'], ['7708722207'], ['5256166011'], ['5258073267'], ['366221019350']];
    }

    public function provideInnWithInvalidControlsum(): array
    {
        return [['3329000314'], ['5256166012'], ['5258073269'], ['366221019351'], ['366221019360'], ['366221019361']];
    }

    public function provideInnWithInvalidLenght(): array
    {
        return [[''], ['52'], ['1234567891234'], ['*-+7/?()'], ['ghfds73267d'], ['абв221019350695']];
    }

    public function provideInnWithNotOnlyDigits(): array
    {
        return [['ghfdsaerƢµ'], ['okptertewqer'], ['ваывавыкеу'], ['(Ͱ)-+=;4№"'], ['चीनीअक्षर1']];
    }

    private function expectExceptionWithMessage(string $message): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($message);
    }
}
