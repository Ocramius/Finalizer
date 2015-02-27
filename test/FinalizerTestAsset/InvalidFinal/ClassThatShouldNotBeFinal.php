<?php

namespace FinalizerTestAsset\InvalidFinal;

/**
 * A class that shouldn't be final, as it does not implement any interface, yet provides API
 */
final class ClassThatShouldNotBeFinal
{
    /**
     * {@inheritDoc}
     */
    public function foo()
    {
    }
}
