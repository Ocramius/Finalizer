<?php

namespace FinalizerTestAsset\Finalizable;

use FinalizerTestAsset\NonFinalizable\EmptyParentClass;

/**
 * A class that can be made final and has no methods, and inherits from a non-finalizable parent
 */
class EmptyChildClass extends EmptyParentClass
{
}
