<?php

namespace YaFou\Validator\Rule;

use YaFou\Validator\Violation;

class BlankRule extends IsNullRule
{
    use NullOrStringSupport;

    private const MESSAGE = 'This value must be blank';

    public function validate($value): ?Violation
    {
        return null === parent::validate($value) ? null : ('' !== $value ? new Violation(self::MESSAGE) : null);
    }
}
