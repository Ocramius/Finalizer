<?php

namespace FinalizerTestAsset\Finalizable;

/**
 * A class that can be made final and acts as an invokable, but also has a constructor
 */
class InvokableClassWithConstructor
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return void
     */
    public function __invoke()
    {
    }
}
