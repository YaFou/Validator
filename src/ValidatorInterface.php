<?php

namespace YaFou\Validator;

interface ValidatorInterface
{
    public function validate($value, array $rules): array;
}
