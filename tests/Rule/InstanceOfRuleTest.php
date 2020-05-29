<?php

namespace YaFou\Validator\Tests\Rule;

use Generator;
use InvalidArgumentException;
use stdClass;
use YaFou\Validator\Rule\InstanceOfRule;
use YaFou\Validator\Tests\TestCase;

class InstanceOfRuleTest extends TestCase
{
    private const TYPES = [
        'string',
        'bool',
        'boolean',
        'int',
        'integer',
        'float',
        'double',
        'numeric',
        'array',
        'null',
        'callable',
        'scalar',
        'resource',
        'object',
        stdClass::class
    ];

    public function testTypeNotExists(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The type "InvalidClass" does not exist');

        new InstanceOfRule('InvalidClass');
    }

    /**
     * @dataProvider provideTypes
     *
     * @param  string $type
     * @return void
     */
    public function testTypeWorks(string $type): void
    {
        $this->assertInstanceOf(InstanceOfRule::class, new InstanceOfRule($type));
    }

    public function provideTypes(): Generator
    {
        foreach (self::TYPES as $type) {
            yield [$type];
        }
    }

    /**
     * @dataProvider provideInvalidValues
     *
     * @param  string $type
     * @param  string $value
     * @return void
     */
    public function testValidateWithAnInvalidValue(string $type, $value): void
    {
        $type = 'boolean' === $type ? 'bool' : $type;

        $this->assertViolationMessageSame(
            sprintf(
                'This value must be an instance of "%s"',
                $type
            ),
            (new InstanceOfRule($type))->validate($value)
        );
    }

    public function provideInvalidValues(): Generator
    {
        $values = [
            'string' => '',
            'bool' => false,
            'boolean' => true,
            'int' => 0,
            'integer' => 1,
            'float' => 0.0,
            'double' => 0.1,
            'numeric' => 2,
            'array' => [],
            'null' => null,
            'callable' => function () {
            },
            'scalar' => false,
            'resource' => fopen('php://stdin', ''),
            'object' => new stdClass(),
            stdClass::class => new stdClass()
        ];

        foreach (self::TYPES as $type) {
            foreach ($values as $valueType => $value) {
                $realType = 'boolean' === $type ? 'bool' : $type;

                if (
                    (function_exists("is_$realType") && ("is_$realType")($value))
                    || (('object' === $type && stdClass::class === $valueType)
                    || (stdClass::class === $type && 'object' === $valueType)                )
                ) {
                    continue;
                }

                if ($type !== $valueType) {
                    yield [$type, $value];
                }
            }
        }
    }

    /**
     * @dataProvider provideValidValues
     *
     * @param  string $type
     * @param  string $value
     * @return void
     */
    public function testValidateWithAValidValue(string $type, $value): void
    {
        $this->assertNull((new InstanceOfRule($type))->validate($value));
    }

    public function provideValidValues(): Generator
    {
        foreach (self::TYPES as $type) {
            if ('string' === $type) {
                yield [$type, ''];
            }

            if ('bool' === $type || 'boolean' === $type) {
                yield [$type, false];
            }

            if ('int' === $type || 'integer' === $type) {
                yield [$type, 0];
            }

            if ('float' === $type || 'double' === $type) {
                yield [$type, 0.0];
            }

            if ('numeric' === $type) {
                yield [$type, 0];
                yield [$type, 0.0];
            }

            if ('array' === $type) {
                yield [$type, []];
            }

            if ('null' === $type) {
                yield [$type, null];
            }

            if ('callable' === $type) {
                yield [$type, function () {
                }];
            }

            if ('scalar' === $type) {
                yield [$type, false];
                yield [$type, 0];
                yield [$type, 0.0];
                yield [$type, ''];
            }

            if ('resource' === $type) {
                yield [$type, fopen('php://stdin', 'r')];
            }

            if ('object' === $type || stdClass::class === $type) {
                yield [$type, new stdClass()];
            }
        }
    }
}
