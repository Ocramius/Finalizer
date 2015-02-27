<?php

namespace FinalizerTestAsset\Finalizable;

use FinalizerTestAsset\EmptyInterface;

/**
 * A class that can be made final and has no public methods
 */
class ClassWithPrivateMethod implements EmptyInterface
{
    /**
     * Unused private method
     */
    private function unused()
    {
    }
}
