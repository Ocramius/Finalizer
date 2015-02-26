<?php

namespace FinalizerTest\Constraint;

use Finalizer\Constraint\IsFinalizable;
use FinalizerTestAsset\Finalizable;
use FinalizerTestAsset\NonFinalizable;

/**
 * @covers \Finalizer\Constraint\IsFinalizable
 */
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
            NonFinalizable\EmptyParentClass::class => [
                new \ReflectionClass(NonFinalizable\EmptyParentClass::class),
                [
                    new \ReflectionClass(Finalizable\EmptyChildClass::class),
                ],
                false,
            ],
            Finalizable\EmptyChildClass::class => [
                new \ReflectionClass(Finalizable\EmptyChildClass::class),
                [],
                true,
            ],
            NonFinalizable\ClassWithNoMethods::class => [
                new \ReflectionClass(NonFinalizable\ClassWithNoMethods::class),
                [],
                false,
            ],
            Finalizable\ClassWithNoMethods::class => [
                new \ReflectionClass(Finalizable\ClassWithNoMethods::class),
                [],
                true,
            ],
            Finalizable\FooMethodClass::class => [
                new \ReflectionClass(Finalizable\FooMethodClass::class),
                [],
                true,
            ],
            Finalizable\FooBarMethodClass::class => [
                new \ReflectionClass(Finalizable\FooBarMethodClass::class),
                [],
                true,
            ],
            NonFinalizable\FooBarMethodClass::class => [
                new \ReflectionClass(NonFinalizable\FooBarMethodClass::class),
                [],
                false,
            ],
            Finalizable\InvokableClass::class => [
                new \ReflectionClass(Finalizable\InvokableClass::class),
                [],
                true,
            ],
            NonFinalizable\InvokableClassWithAdditionalMethods::class => [
                new \ReflectionClass(NonFinalizable\InvokableClassWithAdditionalMethods::class),
                [],
                false,
            ],
        ];
    }
}
