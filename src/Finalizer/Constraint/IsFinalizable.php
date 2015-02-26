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
        return $this->hasChildClasses($class, $definedClasses);
    }

    /**
     * @param \ReflectionClass   $class
     * @param \ReflectionClass[] $definedClasses
     *
     * @return bool
     */
    private function hasChildClasses(\ReflectionClass $class, array $definedClasses)
    {
        return (bool) array_filter(
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
