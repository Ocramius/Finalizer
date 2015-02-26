<?php

namespace FinalizerTestAsset\NonFinalizable;

/**
 * A class that cannot be made final and acts as an invokable because:
 *
 *  - it implements additional methods
 */
class InvokableClassWithAdditionalMethods
{
    /**
     * @return void
     */
    public function __invoke()
    {
    }

    public function bar()
    {
    }
}
