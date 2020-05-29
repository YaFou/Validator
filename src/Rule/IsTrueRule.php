<?php

namespace YaFou\Validator\Rule;

use YaFou\Validator\Violation;

class IsTrueRule extends IsFalseRule
{
    private const MESSAGE = 'This value must be true';

    public function validate($value): ?Violation
    {
        return null === parent::validate($value) ? new Violation(self::MESSAGE) : null;
    }
}
