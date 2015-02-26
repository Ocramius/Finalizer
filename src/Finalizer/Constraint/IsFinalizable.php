<?php

namespace Finalizer\Constraint;

final class IsFinalizable
{
    public function __invoke(\ReflectionClass $class, \ReflectionClass ...$definedClasses)
    {

    }

    /**
     * @param \ReflectionClass   $class
     * @param \ReflectionClass[] $definedClasses
     *
     * @return \ReflectionClass[]
     */
    private function getChildClasses(\ReflectionClass $class, array $definedClasses)
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
}
