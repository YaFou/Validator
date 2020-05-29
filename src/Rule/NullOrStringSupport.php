<?php

namespace YaFou\Validator\Rule;

trait NullOrStringSupport
{
    public function supports($value): bool
    {
        return null === $value || is_string($value);
    }
}
