<?php

namespace YaFou\Validator\Rule;

use YaFou\Validator\Violation;

class NotBlankRule extends NotNullRule
{
    public function validate($value): ?Violation
    {
        return parent::validate($value) ?: ('' === $value ? new Violation('This value must not be blank') : null);
    }
}
