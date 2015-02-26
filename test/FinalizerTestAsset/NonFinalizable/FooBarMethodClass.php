<?php

namespace FinalizerTestAsset\NonFinalizable;

use FinalizerTestAsset\BarMethodInterface;
use FinalizerTestAsset\FooMethodInterface;

/**
 * A class that cannot be made final because
 *
 *  - not all methods are defined in interfaces
 */
class FooBarMethodClass implements FooMethodInterface
{
    /**
     * {@inheritDoc}
     */
    public function foo()
    {
    }

    /**
     * {@inheritDoc}
     *
     * Method implemented, but not defined in an interface
     */
    public function bar()
    {
    }
}
