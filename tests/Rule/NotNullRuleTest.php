<?php

namespace YaFou\Validator\Tests\Rule;

use YaFou\Validator\Rule\NotNullRule;
use YaFou\Validator\Tests\TestCase;

class NotNullRuleTest extends TestCase
{
    /**
     *
     *
     * @var NotNullRule
     */
    private static $rule;

    public static function setUpBeforeClass(): void
    {
        self::$rule = new NotNullRule();
    }

    public function testValueIsNull(): void
    {
        $this->assertViolationMessageSame('This value must not be null', self::$rule->validate(null));
    }

    public function testValueIsNotNull(): void
    {
        $this->assertNull(self::$rule->validate(false));
    }
}
