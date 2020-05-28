<?php

namespace YaFou\Validator\Rule;

use YaFou\Validator\Violation;

class NotNullRule extends AbstractRule
{
    private const MESSAGE = 'This value must not be null';

    public function validate($value): ?Violation
    {
        return null === $value ? new Violation(self::MESSAGE) : null;
    }
}
