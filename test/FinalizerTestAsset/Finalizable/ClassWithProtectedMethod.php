<?php

namespace FinalizerTestAsset\Finalizable;

use FinalizerTestAsset\EmptyInterface;

/**
 * A class that can be made final and has no public methods
 */
class ClassWithProtectedMethod implements EmptyInterface
{
    /**
     * Unused private method
     */
    protected function unused()
    {
    }
}
