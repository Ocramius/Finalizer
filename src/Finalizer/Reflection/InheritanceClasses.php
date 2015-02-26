<?php

namespace Finalizer\Reflection;

final class InheritanceClasses
{
    /**
     * @param \ReflectionClass $class
     *
     * @return \ReflectionClass[]
     */
    public function __invoke(\ReflectionClass $class)
    {
        if ($parentClass = $class->getParentClass()) {
            return array_merge(
                [$class->getName() => $class],
                $this->__invoke($parentClass)
            );
        }

        return [$class->getName() => $class];
    }
}
