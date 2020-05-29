<?php

namespace YaFou\Validator\Tests\Rule;

use Generator;
use stdClass;
use YaFou\Validator\Rule\IsFalseRule;
use YaFou\Validator\Tests\TestCase;

class IsFalseRuleTest extends TestCase
{
    /**
     * 
     *
     * @var IsFalseRule 
     */
    private static $rule;

    public static function setUpBeforeClass(): void
    {
        self::$rule = new IsFalseRule();
    }

    /**
     * @dataProvider provideNonBooleanValues
     *
     * @param  [type] $value
     * @return void
     */
    public function testSupportsNonBooleanValue($value): void
    {
        $this->assertFalse(self::$rule->supports($value));
    }

    public function provideNonBooleanValues(): Generator
    {
        yield [null];
        yield [''];
        yield [[]];
        yield [0];
        yield [0.0];
        yield [new stdClass];
    }

    /**
     * @dataProvider provideBooleanValues
     *
     * @param  [type] $value
     * @return void
     */
    public function testSupportsBooleanValue($value): void
    {
        $this->assertTrue(self::$rule->supports($value));
    }

    public function provideBooleanValues(): Generator
    {
        yield [false];
        yield [true];
    }

    public function testValueIsFalse(): void
    {
        $this->assertNull(self::$rule->validate(false));
    }

    public function testValueIsTrue(): void
    {
        $this->assertViolationMessageSame('This value must be false', self::$rule->validate(true));
    }
}
