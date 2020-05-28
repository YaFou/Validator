<?php

namespace YaFou\Validator\Tests;

use PHPUnit\Framework\TestCase;
use YaFou\Validator\Rule\NotNullRule;
use YaFou\Validator\Violation;

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

    public function testNullValue(): void
    {
        $this->assertEquals(new Violation('This value must not be null'), self::$rule->validate(null));
    }

    public function testGoodValue(): void
    {
        $this->assertNull(self::$rule->validate(false));
    }
}
