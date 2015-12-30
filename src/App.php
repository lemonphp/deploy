<?php

namespace Lemon\Deploy;

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Pimple\Container;
use Lemon\Deploy\Collection\Collection;
use Lemon\Deploy\Console\Application;
use Lemon\Deploy\Console\Command\TaskCommand;
use Lemon\Deploy\Task\Task;
use Lemon\Deploy\Task\GroupTask;

/**
 * Application class
 *
 * @property-read \Symfony\Component\Console\Input\InputInterface   $input
 * @property-read \Symfony\Component\Console\Output\OutputInterface $output
 */
class App
{
    /**
     * @var \Pimple\Container
     */
    protected $container;

    /**
     * @var \Lemon\Deploy\Console\Application
     */
    protected $console;

    /**
     * @var \Lemon\Deploy\Collection\Collection
     */
    protected $tasks;

    /**
     * Constructer
     *
     * @param string $name      Eg. Deployer
     * @param string $version   Eg. 1.0.0
     */
    public function __construct($name, $version)
    {
        $this->container = new Container();
        $this->console   = new Application($name, $version);
        $this->tasks     = new Collection();

        $this->container['input']  = new ArgvInput();
        $this->container['output'] = new ConsoleOutput();
    }

    /**
     * Get service
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return isset($this->container[$name]) ? $this->container[$name] : null;
    }

    /**
     * Check has service
     *
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->container[$name]);
    }

    /**
     * Enable access to the DI container by consumers of $app
     *
     * @return \Pimple\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Add a task
     *
     * @param string $taskName
     * @param callable $callable
     * @return \Lemon\Deploy\Task
     */
    public function task($taskName, $callable)
    {
        // TODO: Resolved callable
        $task = new Task($taskName, $callable);
        $this->tasks->set($taskName, $task);

        return $task;
    }

    /**
     *
     * @param string $taskName
     * @param array $group
     */
    public function group($taskName, $group)
    {
        // TODO: add a group task
        $task = new GroupTask($taskName, function() {

        });
        $this->tasks->set($taskName, $task);

        return $task;
    }

    public function before($taskName, $callable)
    {
        
    }

    public function after($taskName, $callable)
    {
        
    }

    /**
     * Run application
     *
     * @return int  Return 0 if everything went fine, or an error code
     * @throws \Exception
     */
    public function run()
    {
        $input  = $this->container['input'];
        $output = $this->container['output'];

        /* @var $task \Lemon\Deploy\Task\Task */
        foreach ($this->getDefinedTasks() as $taskName) {
            $task = $this->container['task:' . $taskName];
            if (!$task->isPrivate()) {
                $this->console->add(new TaskCommand($task, $this));
            }
        }

        return $this->console->run($input, $output);
    }

    /**
     * @return array
     */
    protected function getDefinedTasks()
    {
        $tasks = [];
        foreach ($this->container->keys() as $key) {
            $match = [];
            if (preg_match('/^task:(.*)$/', $key, $match)) {
                $tasks[] = $match[1];
            }
        }

        return $tasks;
    }

    /**
     * @param string $taskName
     * @return bool
     */
    protected function hasTask($taskName)
    {
        return isset($this->container['task:' . $taskName]);
    }
}
