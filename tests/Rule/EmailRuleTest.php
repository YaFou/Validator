<?php

namespace YaFou\Validator\Tests\Rule;

use Generator;
use stdClass;
use YaFou\Validator\Rule\EmailRule;
use YaFou\Validator\Tests\TestCase;

class EmailRuleTest extends TestCase
{
    /**
     *
     *
     * @var EmailRule
     */
    private static $rule;

    public static function setUpBeforeClass(): void
    {
        self::$rule = new EmailRule();
    }

    /**
     * @dataProvider provideNonStringValues
     *
     * @param  [type] $value
     * @return void
     */
    public function testSupportsNonStringValue($value): void
    {
        $this->assertFalse(self::$rule->supports($value));
    }

    public function provideNonStringValues(): Generator
    {
        yield [null];
        yield [0];
        yield [0.0];
        yield [new stdClass()];
        yield [[]];
        yield [false];
    }

    public function testSupportsStringValue(): void
    {
        $this->assertTrue(self::$rule->supports(''));
    }

    public function testValidateWithBlankValue(): void
    {
        $this->assertViolationMessageSame('This value must not be blank', self::$rule->validate(''));
    }

    /**
     * @dataProvider provideInvalidValues
     *
     * @param  [type] $value
     * @return void
     */
    public function testValidateWithAnInvalidValue($value): void
    {
        $this->assertViolationMessageSame(sprintf('"%s" must be a valid email', $value), self::$rule->validate($value));
    }

    public function provideInvalidValues(): Generator
    {
        yield ['email'];
        yield ['email@'];
        yield ['email@domain'];
    }

    public function testValidateWithAValidValue(): void
    {
        $this->assertNull(self::$rule->validate('email@domain.domain'));
    }
}
