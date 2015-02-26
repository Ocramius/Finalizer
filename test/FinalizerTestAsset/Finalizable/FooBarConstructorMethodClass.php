<?php

namespace FinalizerTestAsset\Finalizable;

use FinalizerTestAsset\BarMethodInterface;
use FinalizerTestAsset\FooMethodInterface;

/**
 * A class that can be made final because all interface methods are implemented
 */
class FooBarConstructorMethodClass implements FooMethodInterface, BarMethodInterface
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

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
