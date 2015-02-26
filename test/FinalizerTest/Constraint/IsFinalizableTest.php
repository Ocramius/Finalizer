<?php

namespace FinalizerTest\Constraint;

use Finalizer\Constraint\IsFinalizable;

class IsFinalizableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider finalizableClassesProvider
     *
     * @param \ReflectionClass   $class
     * @param \ReflectionClass[] $definedClasses
     * @param bool               $expected
     */
    public function testIsFinalizable(\ReflectionClass $class, array $definedClasses, $expected)
    {
        $this->assertSame($expected, (new IsFinalizable())->__invoke($class, ...$definedClasses));
    }

    /**
     * @return \ReflectionClass[][]|\ReflectionClass[][][]
     */
    public function finalizableClassesProvider()
    {
        return [
            'class with parent class' => [
                new \ReflectionClass(\Exception::class),
                [
                    new \ReflectionClass(\LogicException::class),
                ],
                false,
            ],
            'class with no children' => [
                new \ReflectionClass(__CLASS__),
                [],
                true,
            ],
            'final class with (already final, therefore finalizable)' => [
                new \ReflectionClass(\Closure::class),
                [],
                true,
            ],
        ];
    }
}
