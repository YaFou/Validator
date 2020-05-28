<?php

namespace YaFou\Validator\Tests\Rule;

use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use YaFou\Validator\Rule\RangeRule;
use YaFou\Validator\Violation;

class RangeRuleTest extends TestCase
{
    public function testMinAndMaxAreNull(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('At least one variable (min or max) must not be null');
        new RangeRule();
    }

    public function testMinIsEqualThanMax(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The minimum (0) value must be less than the maximum (0)');
        new RangeRule(0, 0);
    }

    public function testMinIsGreaterThanMax(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The minimum (1) value must be less than the maximum (0)');
        new RangeRule(1, 0);
    }

    /**
     * @dataProvider provideNonNumericValues
     *
     * @param  [type] $value
     * @return void
     */
    public function testSupportsNonNumericValue($value): void
    {
        $this->assertFalse((new RangeRule(0))->supports($value));
    }

    public function provideNonNumericValues(): Generator
    {
        yield [null];
        yield [''];
        yield [new stdClass];
        yield [[]];
        yield [false];
    }

    /**
     * @dataProvider provideNumericValues
     *
     * @param  [type] $value
     * @return void
     */
    public function testSupportsNumericValue($value): void
    {
        $this->assertTrue((new RangeRule(0))->supports($value));
    }

    public function provideNumericValues(): Generator
    {
        yield [0];
        yield [0.0];
    }

    public function testValueIsLessThanMin(): void
    {
        $this->assertEquals(new Violation('0 must be greater or equal than 1'), (new RangeRule(1))->validate(0));
        $this->assertEquals(new Violation('0 must be greater or equal than 1'), (new RangeRule(1, 2))->validate(0));
    }

    public function testValueIsGreaterThanMax(): void
    {
        $this->assertEquals(new Violation('1 must be less or equal than 0'), (new RangeRule(null, 0))->validate(1));
        $this->assertEquals(new Violation('1 must be less or equal than 0'), (new RangeRule(-1, 0))->validate(1));
    }

    public function testValueIsEqualThanMin(): void
    {
        $this->assertNull((new RangeRule(0))->validate(0));
        $this->assertNull((new RangeRule(0, 1))->validate(0));
    }

    public function testValueIsEqualThanMax(): void
    {
        $this->assertNull((new RangeRule(null, 0))->validate(0));
        $this->assertNull((new RangeRule(-1, 0))->validate(0));
    }

    public function testValueIsGreaterThanMin(): void
    {
        $this->assertNull((new RangeRule(0))->validate(1));
        $this->assertNull((new RangeRule(0, 1))->validate(1));
    }

    public function testValueIsLessThanMax(): void
    {
        $this->assertNull((new RangeRule(null, 0))->validate(-1));
        $this->assertNull((new RangeRule(-1, 0))->validate(-1));
    }
}
