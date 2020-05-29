<?php

namespace YaFou\Validator\Rule;

use InvalidArgumentException;
use YaFou\Validator\Violation;

class LengthRule extends RangeRule
{
    protected const TEMPLATE_GREATER = '"{value}" length ({length} characters) must be greater or equal than {min}';
    protected const TEMPLATE_LESS = '"{value}" length ({length} characters) must be less or equal than {max}';

    public function __construct(int $min = 0, int $max = null)
    {
        parent::__construct($min, $max);

        if (0 > $min) {
            throw new InvalidArgumentException(sprintf('The minimum length (%s) value must be greater than 0', $min));
        }
    }

    public function supports($value): bool
    {
        return is_string($value);
    }

    public function validate($value): ?Violation
    {
        $length = strlen($value);
        $parentViolation = parent::validate($length);

        if (null === $parentViolation) {
            return null;
        }

        if (parent::TEMPLATE_GREATER === $parentViolation->getTemplate()) {
            return new Violation(self::TEMPLATE_GREATER, ['value' => $value, 'length' => $length, 'min' => $this->min]);
        }

        if (parent::TEMPLATE_LESS === $parentViolation->getTemplate()) {
            return new Violation(self::TEMPLATE_LESS, ['value' => $value, 'length' => $length, 'max' => $this->max]);
        }

        return null;
    }
}
