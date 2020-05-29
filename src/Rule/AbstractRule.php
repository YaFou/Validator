<?php

namespace YaFou\Validator\Rule;

use YaFou\Validator\Violation;

abstract class AbstractRule
{
    abstract public function validate($value): ?Violation;

    public function supports($value): bool
    {
        return true;
    }
}
