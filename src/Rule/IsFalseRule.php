<?php

namespace YaFou\Validator\Rule;

use YaFou\Validator\Violation;

class IsFalseRule extends AbstractRule
{
    private const MESSAGE = 'This value must be false';

    public function supports($value): bool
    {
        return is_bool($value);
    }

    public function validate($value): ?Violation
    {
        return false !== $value ? new Violation(self::MESSAGE) : null;
    }
}
