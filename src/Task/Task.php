<?php

namespace Lemon\Deploy\Task;

use Lemon\Event\Dispatcher;

class Task
{
    protected $name;
    protected $description;
    protected $callable;
    protected $once;
    protected $private;
    /**
     * @var \Lemon\Event\Dispatcher
     */
    protected $eventDispatcher;

    public function __construct($name, $callable)
    {
        $this->name            = (string) $name;
        $this->callable        = $callable;
        $this->eventDispatcher = new Dispatcher();
    }

    public function run(Context $context)
    {
        call_user_func($this->callable, $context);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set task description.
     * @param string $description
     * @return $this
     */
    public function desc($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set this task local and run only once.
     * @return $this
     */
    public function once()
    {
        $this->once = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOnce()
    {
        return $this->once;
    }

    /**
     * @return boolean
     */
    public function isPrivate()
    {
        return $this->private;
    }

    /**
     * Mark task as private.
     */
    public function setPrivate()
    {
        $this->private = true;
        return $this;
    }
}
