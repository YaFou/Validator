<?php

namespace YaFou\Validator\Tests\Rule;

use YaFou\Validator\Rule\IsNullRule;
use YaFou\Validator\Tests\TestCase;

class IsNullRuleTest extends TestCase
{
    private static $rule;

    public static function setUpBeforeClass(): void
    {
        self::$rule = new IsNullRule();
    }

    public function testValueIsNull(): void
    {
        $this->assertNull(self::$rule->validate(null));
    }

    public function testValueIsNotNull(): void
    {
        $this->assertViolationMessageSame('This value must be null', self::$rule->validate(false));
    }
}
