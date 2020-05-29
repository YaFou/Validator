<?php

namespace YaFou\Validator\Rule;

use YaFou\Validator\Violation;

class NotBlankRule extends NotNullRule
{
    use NullOrStringSupport;

    private const MESSAGE = 'This value must not be blank';

    public function validate($value): ?Violation
    {
        return parent::validate($value) ?: ('' === $value ? new Violation(self::MESSAGE) : null);
    }
}
