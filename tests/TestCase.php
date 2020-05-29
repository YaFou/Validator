<?php

namespace YaFou\Validator\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use YaFou\Validator\Violation;

class TestCase extends BaseTestCase
{
    protected static function assertViolationMessageSame(string $expected, Violation $violation): void
    {
        self::assertSame($expected, $violation->getMessage());
    }
}
