<?php

namespace FinalizerTestAsset\Finalizable;

/**
 * A class that can be made final and acts as an invokable
 */
class InvokableClass
{
    /**
     * @return void
     */
    public function __invoke()
    {
    }
}
