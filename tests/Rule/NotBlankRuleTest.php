<?php

namespace YaFou\Validator\Tests\Rule;

use Generator;
use stdClass;
use YaFou\Validator\Rule\NotBlankRule;
use YaFou\Validator\Tests\TestCase;

class NotBlankRuleTest extends TestCase
{
    /**
     *
     *
     * @var NotBlankRule
     */
    private static $rule;

    public static function setUpBeforeClass(): void
    {
        self::$rule = new NotBlankRule();
    }

    /**
     * @dataProvider provideNonStringOrNullValues
     *
     * @param  [type] $value
     * @return void
     */
    public function testSupportsNonStringOrNullValue($value): void
    {
        $this->assertFalse(self::$rule->supports($value));
    }

    public function provideNonStringOrNullValues(): Generator
    {
        yield [false];
        yield [0];
        yield [0.0];
        yield [[]];
        yield [new stdClass()];
    }

    /**
     * @dataProvider provideStringOrNullValues
     *
     * @param  [type] $value
     * @return void
     */
    public function testSupportsStringOrNullValue($value): void
    {
        $this->assertTrue(self::$rule->supports($value));
    }

    public function provideStringOrNullValues(): Generator
    {
        yield [null];
        yield [''];
    }

    public function testValueIsNull(): void
    {
        $this->assertViolationMessageSame('This value must not be null', self::$rule->validate(null));
    }

    public function testValueIsEmpty(): void
    {
        $this->assertViolationMessageSame('This value must not be blank', self::$rule->validate(''));
    }

    public function testValueIsNotEmpty(): void
    {
        $this->assertNull(self::$rule->validate('string'));
    }
}
