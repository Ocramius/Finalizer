<?php

namespace Finalizer\Iterator;

final class MapIterator implements \Iterator
{
    /**
     * @var \Iterator
     */
    private $wrappedIterator;

    /**
     * @var callable
     */
    private $map;

    /**
     * @param \Iterator $wrappedIterator
     * @param callable  $map
     */
    public function __construct(\Iterator $wrappedIterator, callable $map)
    {
        $this->wrappedIterator = $wrappedIterator;
        $this->map             = $map;
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        $map = $this->map;

        return $map($this->wrappedIterator->current());
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        $this->wrappedIterator->next();
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return $this->wrappedIterator->key();
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        return $this->wrappedIterator->valid();
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->wrappedIterator->rewind();
    }
}
