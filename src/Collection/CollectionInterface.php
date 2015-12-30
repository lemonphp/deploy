<?php

namespace Lemon\Deploy\Collection;

interface CollectionInterface extends \IteratorAggregate
{
    /**
     * Get item
     * @param string $name
     * @return mixed
     */
    public function get($name);

    /**
     * Set item
     * @param string $name
     * @param mixed $object
     */
    public function set($name, $object);

    /**
     * Remove item
     * @param string $name
     */
    public function remove($name);

    /**
     * Check item exist
     * @param string $name
     * @return mixed
     */
    public function has($name);
}
