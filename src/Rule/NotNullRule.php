<?php

namespace YaFou\Validator\Rule;

use YaFou\Validator\Violation;

class NotNullRule extends IsNullRule
{
    private const MESSAGE = 'This value must not be null';

    public function validate($value): ?Violation
    {
        return null === parent::validate($value) ? new Violation(self::MESSAGE) : null;
    }
}
