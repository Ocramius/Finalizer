<?php

namespace FinalizerTest\Reflection;

use Finalizer\Iterator\MapIterator;

/**
 * @covers \Finalizer\Iterator\MapIterator
 */
class MapIteratorTest extends \PHPUnit_Framework_TestCase
{
    public function testCurrent()
    {
        /* @var $map callable|\PHPUnit_Framework_MockObject_MockObject */
        $map             = $this->getMock(\stdClass::class, ['__invoke']);
        /* @var $wrappedIterator \Iterator|\PHPUnit_Framework_MockObject_MockObject */
        $wrappedIterator = $this->getMock(\Iterator::class);

        $wrappedIterator->expects($this->at(0))->method('current')->will($this->returnValue('foo'));
        $wrappedIterator->expects($this->at(1))->method('current')->will($this->returnValue('bar'));

        $map->expects($this->at(0))->method('__invoke')->with('foo')->will($this->returnValue('baz'));
        $map->expects($this->at(1))->method('__invoke')->with('bar')->will($this->returnValue('tab'));

        $iterator = new MapIterator($wrappedIterator, $map);

        $this->assertSame('baz', $iterator->current());
        $this->assertSame('tab', $iterator->current());
    }

    public function testNext()
    {
        /* @var $map callable|\PHPUnit_Framework_MockObject_MockObject */
        $map             = $this->getMock(\stdClass::class, ['__invoke']);
        /* @var $wrappedIterator \Iterator|\PHPUnit_Framework_MockObject_MockObject */
        $wrappedIterator = $this->getMock(\Iterator::class);

        $wrappedIterator->expects($this->exactly(2))->method('next');

        $map->expects($this->never())->method('__invoke');

        $iterator = new MapIterator($wrappedIterator, $map);

        $iterator->next();
        $iterator->next();
    }

    public function testRewind()
    {
        /* @var $map callable|\PHPUnit_Framework_MockObject_MockObject */
        $map             = $this->getMock(\stdClass::class, ['__invoke']);
        /* @var $wrappedIterator \Iterator|\PHPUnit_Framework_MockObject_MockObject */
        $wrappedIterator = $this->getMock(\Iterator::class);

        $wrappedIterator->expects($this->exactly(2))->method('rewind');

        $map->expects($this->never())->method('__invoke');

        $iterator = new MapIterator($wrappedIterator, $map);

        $iterator->rewind();
        $iterator->rewind();
    }

    public function testKey()
    {
        /* @var $map callable|\PHPUnit_Framework_MockObject_MockObject */
        $map             = $this->getMock(\stdClass::class, ['__invoke']);
        /* @var $wrappedIterator \Iterator|\PHPUnit_Framework_MockObject_MockObject */
        $wrappedIterator = $this->getMock(\Iterator::class);

        $wrappedIterator->expects($this->at(0))->method('key')->will($this->returnValue('foo'));
        $wrappedIterator->expects($this->at(1))->method('key')->will($this->returnValue('bar'));

        $map->expects($this->never())->method('__invoke');

        $iterator = new MapIterator($wrappedIterator, $map);

        $this->assertSame('foo', $iterator->key());
        $this->assertSame('bar', $iterator->key());
    }

    public function testValid()
    {
        /* @var $map callable|\PHPUnit_Framework_MockObject_MockObject */
        $map             = $this->getMock(\stdClass::class, ['__invoke']);
        /* @var $wrappedIterator \Iterator|\PHPUnit_Framework_MockObject_MockObject */
        $wrappedIterator = $this->getMock(\Iterator::class);

        $wrappedIterator->expects($this->at(0))->method('key')->will($this->returnValue(true));
        $wrappedIterator->expects($this->at(1))->method('key')->will($this->returnValue(false));

        $map->expects($this->never())->method('__invoke');

        $iterator = new MapIterator($wrappedIterator, $map);

        $this->assertTrue($iterator->key());
        $this->assertFalse($iterator->key());
    }

    /**
     * @coversNothing
     */
    public function testIterationWithActualArrayIterator()
    {
        $this->assertEquals(
            [2, 4, 6],
            iterator_to_array(new MapIterator(
                new \ArrayIterator([1, 2, 3]),
                function ($value) {
                    return $value * 2;
                }
            ))
        );
    }
}
