<?php

namespace FinalizerTestAsset\Finalizable;

use FinalizerTestAsset\EmptyInterface;

/**
 * A class that can be made final and has no methods except for a constructor
 */
class ClassWithConstructor implements EmptyInterface
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }
}
