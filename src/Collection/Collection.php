<?php

namespace Lemon\Deploy\Collection;

class Collection implements CollectionInterface, \Countable
{
    /**
     * @var array
     */
    private $storage = [];

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        if ($this->has($name)) {
            return $this->storage[$name];
        } else {
            $class = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
            throw new \RuntimeException("Object `$name` does not exist in $class.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $object)
    {
        $this->storage[$name] = $object;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($name)
    {
        unset($this->storage[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        return array_key_exists($name, $this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->storage);
    }
}
