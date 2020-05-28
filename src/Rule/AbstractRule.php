<?php

namespace YaFou\Validator\Rule;

use YaFou\Validator\Violation;

abstract class AbstractRule
{
    public abstract function validate($value): ?Violation;
}
