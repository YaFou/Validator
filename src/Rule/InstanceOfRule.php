<?php

namespace YaFou\Validator\Rule;

use InvalidArgumentException;
use YaFou\Validator\Violation;

class InstanceOfRule extends AbstractRule
{
    private const TYPE = 'type';
    private const CLASS_TYPE = 'class';
    private const TEMPLATE = 'This value must be an instance of "{type}"';

    private $type;
    private $function;

    public function __construct(string $type)
    {
        $type = 'boolean' === $type ? 'bool' : $type;

        if(function_exists("is_$type")) {
            $this->function = self::TYPE;
        }

        else if(class_exists($type)) {
            $this->function = self::CLASS_TYPE;
        }

        else {
            throw new InvalidArgumentException(sprintf('The type "%s" does not exists', $type));
        }

        $this->type = $type;
    }

    public function validate($value): ?Violation
    {
        if((self::TYPE === $this->function && !("is_{$this->type}")($value)) 
            || (self::CLASS_TYPE === $this->function && (!is_object($value) || get_class($value) !== $this->type))
        ) {
            return new Violation(self::TEMPLATE, ['type' => $this->type]);
        }

        return null;
    }
}
