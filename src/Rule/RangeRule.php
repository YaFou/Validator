<?php

namespace YaFou\Validator\Rule;

use InvalidArgumentException;
use YaFou\Validator\Violation;

class RangeRule extends AbstractRule
{
    protected const TEMPLATE_GREATER = '{value} must be greater or equal than {min}';
    protected const TEMPLATE_LESS = '{value} must be less or equal than {max}';

    protected $min;
    protected $max;

    public function __construct(float $min = null, float $max = null)
    {
        if(null === $min && null === $max) {
            throw new InvalidArgumentException('At least one variable (min or max) must not be null');
        }

        if(null !== $min && null !== $max && $min >= $max) {
            throw new InvalidArgumentException(
                sprintf(
                    'The minimum (%s) value must be less than the maximum (%s)',
                    $min,
                    $max
                )
            );
        }

        $this->min = $min;
        $this->max = $max;
    }

    public function supports($value): bool
    {
        return is_numeric($value);
    }

    public function validate($value): ?Violation
    {
        if(null !== $this->min && $this->min > $value) {
            return new Violation(self::TEMPLATE_GREATER, ['value' => $value, 'min' => $this->min]);
        }
            
        if(null !== $this->max && $this->max < $value) {
            return new Violation(self::TEMPLATE_LESS, ['value' => $value, 'max' => $this->max]);
        }

        return null;
    }
}
