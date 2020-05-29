<?php

namespace YaFou\Validator\Tests\Rule;

use YaFou\Validator\Rule\IsNullRule;
use YaFou\Validator\Tests\TestCase;

class IsNullRuleTest extends TestCase
{
    /**
     * 
     *
     * @var IsNullRule
     */
    private static $rule;

    public static function setUpBeforeClass(): void
    {
        self::$rule = new IsNullRule();
    }

    public function TestValueIsNull(): void
    {
        $this->assertNull(self::$rule->validate(null));
    }

    public function testValueIsNotNull(): void
    {
        $this->assertViolationMessageSame('This value must be null', self::$rule->validate(false));
    }
}
