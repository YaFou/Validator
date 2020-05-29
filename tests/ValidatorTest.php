<?php

namespace YaFou\Validator\Tests;

use PHPUnit\Framework\TestCase;
use YaFou\Validator\Rule\NotBlankRule;
use YaFou\Validator\Rule\NotNullRule;
use YaFou\Validator\Rule\RangeRule;
use YaFou\Validator\Validator;
use YaFou\Validator\Violation;
use YaFou\Validator\ViolationCollection;

class ValidatorTest extends TestCase
{
    private static $validator;

    public static function setUpBeforeClass(): void
    {
        self::$validator = new Validator();
    }

    public function testOneRuleWithFailure(): void
    {
        $this->assertEquals(
            new ViolationCollection([new Violation('This value must not be null')]),
            self::$validator->validate(null, [new NotNullRule()])
        );
    }

    public function testOneRuleWithSuccess(): void
    {
        $this->assertEmpty(self::$validator->validate(false, [new NotNullRule()]));
    }

    public function testTwoRulesWithFailure(): void
    {
        $this->assertEquals(
            new ViolationCollection([new Violation('This value must not be null')]),
            self::$validator->validate(null, [new NotNullRule(), new NotBlankRule()])
        );
    }

    public function testTwoRulesWithOneSuccessAndOneFailure(): void
    {
        $this->assertEquals(
            new ViolationCollection([new Violation('This value must not be blank')]),
            self::$validator->validate('', [new NotNullRule(), new NotBlankRule()])
        );
    }

    public function testValueIsNotSupported(): void
    {
        $this->assertEmpty(self::$validator->validate(null, [new RangeRule(-1)]));
    }

    public function testValueIsSupported(): void
    {
        $this->assertEquals(
            new ViolationCollection([new Violation(
                '{value} must be greater or equal than {min}',
                ['value' => 0, 'min' => 1]
            )]),
            self::$validator->validate(0, [new RangeRule(1)])
        );
    }
}
