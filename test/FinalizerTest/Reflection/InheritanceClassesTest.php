<?php

namespace FinalizerTest\Reflection;

use Finalizer\Reflection\InheritanceClasses;

/**
 * @covers \Finalizer\Reflection\InheritanceClasses
 */
class InheritanceClassesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider classesProvider
     *
     * @param string   $className
     * @param string[] $expectedClasses
     */
    public function testInheritanceClasses($className, array $expectedClasses)
    {
        $indexedClasses = array_combine(
            $expectedClasses,
            array_map(
                function ($className) {
                    return new \ReflectionClass($className);
                },
                $expectedClasses
            )
        );

        $this->assertEquals(
            $indexedClasses,
            (new InheritanceClasses())->__invoke(new \ReflectionClass($className))
        );
    }

    /**
     * @return string[][]|string[][][]
     */
    public function classesProvider()
    {
        return [
            'class with no parent class' => [
                \Exception::class,
                [
                    \Exception::class,
                ],
                false,
            ],
            'class with one parent class' => [
                \LogicException::class,
                [
                    \LogicException::class,
                    \Exception::class,
                ],
                false,
            ],
            'class with multiple parent classes' => [
                \InvalidArgumentException::class,
                [
                    \InvalidArgumentException::class,
                    \LogicException::class,
                    \Exception::class,
                ],
                false,
            ],
        ];
    }
}
