<?php

namespace FinalizerTestAsset\NonFinalizable;
use FinalizerTestAsset\EmptyInterface;

/**
 * A class that cannot be made final because:
 *
 *  - it has child classes
 */
class EmptyParentClass implements EmptyInterface
{
}
