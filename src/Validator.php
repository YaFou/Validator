<?php

namespace YaFou\Validator;

class Validator implements ValidatorInterface
{
    public function validate($value, array $rules): array
    {
        $violations = [];

        foreach ($rules as $rule) {
            if (!$rule->supports($value)) {
                continue;
            }

            if (null !== $violation = $rule->validate($value)) {
                if (!in_array($violation, $violations)) {
                    $violations[] = $violation;
                }
            }
        }

        return $violations;
    }
}
