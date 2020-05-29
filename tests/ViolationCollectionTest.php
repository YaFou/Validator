<?php

namespace YaFou\Validator\Tests;

use ArrayAccess;
use IteratorAggregate;
use LogicException;
use PHPUnit\Framework\TestCase;
use YaFou\Validator\Violation;
use YaFou\Validator\ViolationCollection;

class ViolationCollectionTest extends TestCase
{
    private static $violation;

    public static function setUpBeforeClass(): void
    {
        self::$violation = new Violation('');
    }

    public function testImplementsArrayAccess(): void
    {
        $this->assertInstanceOf(ArrayAccess::class, new ViolationCollection());
    }

    public function testConstructorAndInArray(): void
    {
        $this->assertSame([self::$violation], (new ViolationCollection([self::$violation]))->toArray());
    }

    public function testOffsetDoesNotExist(): void
    {
        $this->assertFalse((new ViolationCollection())->offsetExists(0));
    }

    public function testOffsetExists(): void
    {
        $this->assertTrue((new ViolationCollection([self::$violation]))->offsetExists(0));
    }

    public function testOffsetGet(): void
    {
        $collection = new ViolationCollection([self::$violation]);
        $this->assertSame(self::$violation, $collection->offsetGet(0));
        $this->assertSame(self::$violation, $collection[0]);
    }

    public function testOffsetPush(): void
    {
        $collection = new ViolationCollection();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("A violation collection is immutbale, it can't be edited");
        $collection->offsetSet(0, self::$violation);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("A violation collection is immutbale, it can't be edited");
        $collection[] = self::$violation;
    }


    public function testOffsetSet(): void
    {
        $collection = new ViolationCollection([self::$violation]);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("A violation collection is immutbale, it can't be edited");
        $collection->offsetSet(0, self::$violation);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("A violation collection is immutbale, it can't be edited");
        $collection[] = self::$violation;
    }

    public function testOffsetUnset(): void
    {
        $collection = new ViolationCollection();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("A violation collection is immutbale, it can't be edited");
        $collection->offsetUnset(0);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("A violation collection is immutbale, it can't be edited");
        unset($collection[0]);
    }

    public function testToJson(): void
    {
        $this->assertSame(
            [['message' => '', 'template' => '']],
            json_decode((new ViolationCollection([self::$violation]))->toJson(), true)
        );
    }

    public function testImplementsIteratorAggregate(): void
    {
        $this->assertInstanceOf(IteratorAggregate::class, new ViolationCollection());
    }

    public function testIterator(): void
    {
        $collection = new ViolationCollection([self::$violation]);

        foreach ($collection as $violation) {
            $this->assertSame(self::$violation, $violation);
        }
    }

    public function testCountWithNoViolation(): void
    {
        $this->assertEmpty(new ViolationCollection());
    }

    public function testCountWithOneViolation(): void
    {
        $this->assertCount(1, new ViolationCollection([self::$violation]));
    }
}
