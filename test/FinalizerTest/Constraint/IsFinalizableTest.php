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
     * @param string   $className
     * @param string[] $definedClasses
     */
    public function testIsFinalizable($className, array $definedClasses)
    {
        $finalizable = false === strpos($className, 'NonFinalizable');

        $this->assertSame(
            $finalizable,
            (new IsFinalizable())
                ->__invoke(
                    new \ReflectionClass($className),
                    ...array_map(
                        function ($className) {
                            return new \ReflectionClass($className);
                        },
                        $definedClasses
                    )
                )
        );
    }

    /**
     * @return \ReflectionClass[][]|\ReflectionClass[][][]
     */
    public function finalizableClassesProvider()
    {
        return [
            NonFinalizable\EmptyParentClass::class => [
                NonFinalizable\EmptyParentClass::class,
                [
                    Finalizable\EmptyChildClass::class,
                ],
            ],
            Finalizable\EmptyChildClass::class => [
                Finalizable\EmptyChildClass::class,
                [],
            ],
            NonFinalizable\ClassWithNoMethods::class => [
                NonFinalizable\ClassWithNoMethods::class,
                [],
            ],
            Finalizable\ClassWithNoMethods::class => [
                Finalizable\ClassWithNoMethods::class,
                [],
            ],
            Finalizable\FooMethodClass::class => [
                Finalizable\FooMethodClass::class,
                [],
            ],
            Finalizable\FooBarMethodClass::class => [
                Finalizable\FooBarMethodClass::class,
                [],
            ],
            NonFinalizable\FooBarMethodClass::class => [
                NonFinalizable\FooBarMethodClass::class,
                [],
            ],
            Finalizable\InvokableClass::class => [
                Finalizable\InvokableClass::class,
                [],
            ],
            NonFinalizable\InvokableClassWithAdditionalMethods::class => [
                NonFinalizable\InvokableClassWithAdditionalMethods::class,
                [],
            ],
            Finalizable\InvokableClassWithConstructor::class => [
                Finalizable\InvokableClassWithConstructor::class,
                [],
            ],
            Finalizable\ClassWithConstructor::class => [
                Finalizable\ClassWithConstructor::class,
                [],
            ],
            Finalizable\FooBarConstructorMethodClass::class => [
                Finalizable\FooBarConstructorMethodClass::class,
                [],
            ],
            Finalizable\ClassWithPrivateMethod::class => [
                Finalizable\ClassWithPrivateMethod::class,
                [],
            ],
            Finalizable\ClassWithProtectedMethod::class => [
                Finalizable\ClassWithProtectedMethod::class,
                [],
            ],
        ];
    }
}
