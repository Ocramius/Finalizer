<?php

namespace Finalizer\Constraint;

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
            && ! $this->hasChildClasses($class, $definedClasses)
            && (
                ($class->getInterfaces() && $this->implementsOnlyInterfaceMethods($class))
                || $this->isOnlyInvokable($class)
            );
    }

    /**
     * Checks whether a given class is an invokable, and whether no other methods are implemented on it
     *
     * @param \ReflectionClass $class
     *
     * @return bool
     */
    private function isOnlyInvokable(\ReflectionClass $class)
    {
        return ['__invoke'] === array_values(array_map('strtolower', $this->getNonConstructorMethodNames($class)))
            && ! $class->getMethod('__invoke')->isStatic();
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
            $this->getNonConstructorMethodNames($class),
            array_merge(
                [],
                [],
                ...array_values(array_map(
                    [$this, 'getNonConstructorMethodNames'],
                    $class->getInterfaces()
                ))
            )
        );
    }

    /**
     * @param \ReflectionClass $class
     *
     * @return string[] (indexed numerically)
     */
    private function getNonConstructorMethodNames(\ReflectionClass $class)
    {
        return array_values(array_map(
            function (\ReflectionMethod $method) {
                return $method->getName();
            },
            array_filter(
                $class->getMethods(),
                function (\ReflectionMethod $method) {
                    return ! $method->isConstructor();
                }
            )
        ));
    }
}
