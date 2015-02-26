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
     */
    public function testIsFinalizable(\ReflectionClass $class, array $definedClasses)
    {
        $finalizable = false === strpos($class->getName(), 'NonFinalizable');

        $this->assertSame($finalizable, (new IsFinalizable())->__invoke($class, ...$definedClasses));
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
            ],
            Finalizable\EmptyChildClass::class => [
                new \ReflectionClass(Finalizable\EmptyChildClass::class),
                [],
            ],
            NonFinalizable\ClassWithNoMethods::class => [
                new \ReflectionClass(NonFinalizable\ClassWithNoMethods::class),
                [],
            ],
            Finalizable\ClassWithNoMethods::class => [
                new \ReflectionClass(Finalizable\ClassWithNoMethods::class),
                [],
            ],
            Finalizable\FooMethodClass::class => [
                new \ReflectionClass(Finalizable\FooMethodClass::class),
                [],
            ],
            Finalizable\FooBarMethodClass::class => [
                new \ReflectionClass(Finalizable\FooBarMethodClass::class),
                [],
            ],
            NonFinalizable\FooBarMethodClass::class => [
                new \ReflectionClass(NonFinalizable\FooBarMethodClass::class),
                [],
            ],
            Finalizable\InvokableClass::class => [
                new \ReflectionClass(Finalizable\InvokableClass::class),
                [],
            ],
            NonFinalizable\InvokableClassWithAdditionalMethods::class => [
                new \ReflectionClass(NonFinalizable\InvokableClassWithAdditionalMethods::class),
                [],
            ],
            Finalizable\InvokableClassWithConstructor::class => [
                new \ReflectionClass(Finalizable\InvokableClassWithConstructor::class),
                [],
            ],
            Finalizable\ClassWithConstructor::class => [
                new \ReflectionClass(Finalizable\ClassWithConstructor::class),
                [],
            ],
        ];
    }
}
