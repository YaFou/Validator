<?php

namespace YaFou\Validator\Tests\Rule;

use Generator;
use stdClass;
use YaFou\Validator\Rule\BlankRule;
use YaFou\Validator\Tests\TestCase;

class BlankRuleTest extends TestCase
{
    /**
     * 
     *
     * @var BlankRule 
     */
    private static $rule;

    public static function setUpBeforeClass(): void
    {
        self::$rule = new BlankRule();
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
        $this->assertNull(self::$rule->validate(null));
    }

    public function testValueIsEmpty(): void
    {
        $this->assertNull(self::$rule->validate(''));
    }

    public function testValueIsNotEmpty(): void
    {
        $this->assertViolationMessageSame('This value must be blank', self::$rule->validate('string'));
    }
}
