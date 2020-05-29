<?php

namespace YaFou\Validator\Tests;

use PHPUnit\Framework\TestCase;
use YaFou\Validator\Violation;

class ViolationTest extends TestCase
{
    public function testTemplateHasNoVariables(): void
    {
        $this->assertSame('message', (new Violation('message'))->getMessage());
    }

    public function testTemplateHasOneVariable(): void
    {
        $this->assertSame('message value', (new Violation('message {key}', ['key' => 'value']))->getMessage());
    }

    public function testTemplateHasTwoVariables(): void
    {
        $this->assertSame(
            'value1 message value2',
            (new Violation('{key1} message {key2}', ['key1' => 'value1', 'key2' => 'value2']))->getMessage()
        );
    }

    public function testTemplateHasOneVariableTwoTimes(): void
    {
        $this->assertSame(
            'value message value',
            (new Violation('{key} message {key}', ['key' => 'value']))->getMessage()
        );
    }

    public function testTemplateHasTwoVariablesTwoTimes(): void
    {
        $this->assertSame(
            'value1 value2 message value2 value1',
            (new Violation(
                '{key1} {key2} message {key2} {key1}',
                ['key1' => 'value1', 'key2' => 'value2']
            ))->getMessage()
        );
    }
}
