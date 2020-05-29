<?php

namespace YaFou\Validator\Rule;

use YaFou\Validator\Violation;

class EmailRule extends NotBlankRule
{
    private const TEMPLATE = '"{value}" must be a valid email';

    public function supports($value): bool
    {
        return is_string($value);
    }

    public function validate($value): ?Violation
    {
        return parent::validate($value) ?: (
            !filter_var($value, FILTER_VALIDATE_EMAIL) ?
            new Violation(self::TEMPLATE, ['value' => $value]) :
            null
        );
    }
}
