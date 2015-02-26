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
     * @param \ReflectionClass   $class
     * @param \ReflectionClass[] $expectedClasses
     */
    public function testInheritanceClasses(\ReflectionClass $class, array $expectedClasses)
    {
        $indexedClasses = array_combine(
            array_values(array_map(
                function (\ReflectionClass $class) {
                    return $class->getName();
                },
                $expectedClasses
            )),
            $expectedClasses
        );

        $this->assertEquals($indexedClasses, (new InheritanceClasses())->__invoke($class));
    }

    /**
     * @return \ReflectionClass[][]|\ReflectionClass[][][]
     */
    public function classesProvider()
    {
        return [
            'class with no parent class' => [
                new \ReflectionClass(\Exception::class),
                [
                    new \ReflectionClass(\Exception::class),
                ],
                false,
            ],
            'class with one parent class' => [
                new \ReflectionClass(\LogicException::class),
                [
                    new \ReflectionClass(\LogicException::class),
                    new \ReflectionClass(\Exception::class),
                ],
                false,
            ],
            'class with multiple parent classes' => [
                new \ReflectionClass(\InvalidArgumentException::class),
                [
                    new \ReflectionClass(\InvalidArgumentException::class),
                    new \ReflectionClass(\LogicException::class),
                    new \ReflectionClass(\Exception::class),
                ],
                false,
            ],
        ];
    }
}
