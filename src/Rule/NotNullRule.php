<?php

namespace YaFou\Validator\Rule;

use YaFou\Validator\Violation;

class NotNullRule extends AbstractRule
{
    public function validate($value): ?Violation
    {
        return null === $value ? new Violation('This value must not be null') : null;
    }
}
