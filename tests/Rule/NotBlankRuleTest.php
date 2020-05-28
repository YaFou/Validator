<?php

namespace YaFou\Validator\Tests;

use PHPUnit\Framework\TestCase;
use YaFou\Validator\Rule\NotBlankRule;
use YaFou\Validator\Violation;

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

    public function testNullValue(): void
    {
        $this->assertEquals(new Violation('This value must not be null'), self::$rule->validate(null));
    }

    public function testEmptyValue(): void
    {
        $this->assertEquals(new Violation('This value must not be blank'), self::$rule->validate(''));
    }

    public function testGoodValue(): void
    {
        $this->assertNull(self::$rule->validate('string'));
    }
}
