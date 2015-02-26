<?php

namespace FinalizerTestAsset\Finalizable;

use FinalizerTestAsset\BarMethodInterface;
use FinalizerTestAsset\FooMethodInterface;

/**
 * A class that can be made final because all interface methods are implemented
 */
class FooBarMethodClass implements FooMethodInterface, BarMethodInterface
{
    /**
     * {@inheritDoc}
     */
    public function foo()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function bar()
    {
    }
}
