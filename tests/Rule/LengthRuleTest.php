<?php

namespace YaFou\Validator\Tests\Rule;

use Generator;
use InvalidArgumentException;
use stdClass;
use YaFou\Validator\Rule\LengthRule;
use YaFou\Validator\Tests\TestCase;

class LengthRuleTest extends TestCase
{
    public function testMinIsEqualThanMax(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The minimum (0) value must be less than the maximum (0)');
        new LengthRule(0, 0);
    }

    public function testMinIsGreaterThanMax(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The minimum (1) value must be less than the maximum (0)');
        new LengthRule(1, 0);
    }

    public function testMinIsLessThanZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The minimum length (-1) value must be greater than 0');
        new LengthRule(-1);
    }

    /**
     * @dataProvider provideNonStringValues
     *
     * @param  [type] $value
     * @return void
     */
    public function testSupportsNonStringValue($value): void
    {
        $this->assertFalse((new LengthRule(0))->supports($value));
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
        $this->assertTrue((new LengthRule(0))->supports(''));
    }

    public function testLengthIsLessThanMin(): void
    {
        $this->assertViolationMessageSame(
            '"" length (0 characters) must be greater or equal than 1',
            (new LengthRule(1))->validate('')
        );


        $this->assertViolationMessageSame(
            '"" length (0 characters) must be greater or equal than 1',
            (new LengthRule(1, 2))->validate('')
        );
    }

    public function testLengthIsGreaterThanMax(): void
    {
        $this->assertViolationMessageSame(
            '"string" length (6 characters) must be less or equal than 1',
            (new LengthRule(0, 1))->validate('string')
        );

        $this->assertViolationMessageSame(
            '"string" length (6 characters) must be less or equal than 1',
            (new LengthRule(0, 1))->validate('string')
        );
    }

    public function testLengthIsEqualThanMin(): void
    {
        $this->assertNull((new LengthRule(0))->validate(''));
        $this->assertNull((new LengthRule(0, 1))->validate(''));
    }

    public function testLengthIsEqualThanMax(): void
    {
        $this->assertNull((new LengthRule(0, 1))->validate('s'));
    }

    public function testLengthIsGreaterThanMin(): void
    {
        $this->assertNull((new LengthRule(0))->validate('string'));
        $this->assertNull((new LengthRule(0, 6))->validate('string'));
    }

    public function testLengthIsLessThanMax(): void
    {
        $this->assertNull((new LengthRule(0, 7))->validate('string'));
    }
}
