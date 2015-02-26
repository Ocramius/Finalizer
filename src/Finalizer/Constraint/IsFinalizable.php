<?php

namespace Finalizer\Constraint;

use Finalizer\Reflection\InheritanceClasses;

final class IsFinalizable
{
    /**
     * @param \ReflectionClass $class
     * @param \ReflectionClass ...$definedClasses
     *
     * @return bool
     */
    public function __invoke(\ReflectionClass $class, \ReflectionClass ...$definedClasses)
    {
        return ! $class->isAbstract()
            && $class->getInterfaces()
            && ! $this->hasChildClasses($class, $definedClasses)
            && $this->implementsOnlyInterfaceMethods($class);
    }

    /**
     * @param \ReflectionClass   $class
     * @param \ReflectionClass[] $definedClasses
     *
     * @return bool
     */
    private function hasChildClasses(\ReflectionClass $class, array $definedClasses)
    {
        return array_filter(
            $definedClasses,
            function (\ReflectionClass $childClassCandidate) use ($class) {
                $parentClass = $childClassCandidate->getParentClass();

                if (! $parentClass) {
                    return false;
                }

                return $parentClass->getName() === $class->getName();
            }
        );
    }

    /**
     * Checks whether all methods implemented by $class are defined in
     * interfaces implemented by $class
     *
     * @param \ReflectionClass $class
     *
     * @return bool
     */
    private function implementsOnlyInterfaceMethods(\ReflectionClass $class)
    {
        return ! array_diff(
            array_map(
                function (\ReflectionMethod $method) {
                    return $method->getName();
                },
                $class->getMethods()
            ),
            array_merge(
                [],
                [],
                ...array_values(array_map(
                    function (\ReflectionClass $interface) {
                        return array_map(
                            function (\ReflectionMethod $method) {
                                return $method->getName();
                            },
                            $interface->getMethods()
                        );
                    },
                    $class->getInterfaces()
                ))
            )
        );
    }
}
