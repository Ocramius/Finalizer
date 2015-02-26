<?php

namespace FinalizerTestAsset\NonFinalizable;

use FinalizerTestAsset\EmptyInterface;

/**
 * An abstract class that cannot be made final because:
 *
 *  - it is abstract
 */
abstract class AbstractEmptyClassImplementingEmptyInterface implements EmptyInterface
{
}
