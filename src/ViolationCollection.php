<?php

namespace YaFou\Validator;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use LogicException;

class ViolationCollection implements ArrayAccess, IteratorAggregate, Countable
{
    private $violations;

    public function __construct(array $violations = [])
    {
        $this->violations = $violations;
    }

    public function offsetExists($offset)
    {
        return isset($this->violations[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->violations[$offset] ?? null;
    }

    public function offsetSet($offset, $value)
    {
        $this->throwImmutableException();
    }

    public function offsetUnset($offset)
    {
        $this->throwImmutableException();
    }

    private function throwImmutableException(): void
    {
        throw new LogicException("A violation collection is immutbale, it can't be edited");
    }

    public function toArray(): array
    {
        return $this->violations;
    }

    public function toJson(): string
    {
        $violations = array_map(function (Violation $violation) {
            return [
                'message' => $violation->getMessage(),
                'template' => $violation->getTemplate()
            ];
        }, $this->toArray());
        
        return json_encode($violations);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->violations);
    }

    public function count()
    {
        return count($this->violations);
    }
}
