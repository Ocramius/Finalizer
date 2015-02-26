<?php

namespace FinalizerTestAsset\Finalizable;

use FinalizerTestAsset\FooMethodInterface;

/**
 * A class that can be made final because all interface methods are implemented
 */
class FooMethodClass implements FooMethodInterface
{
    /**
     * {@inheritDoc}
     */
    public function foo()
    {
    }
}
