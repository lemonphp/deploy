<?php

namespace Lemon\Deploy\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Lemon\Deploy\Task\Task;
use Lemon\Deploy\Task\Context;
use Lemon\Deploy\App;

class TaskCommand extends Command
{

    /**
     * @var \Lemon\Deploy\Task\Task
     */
    protected $task;

    /**
     * @param Task $task
     * @param App $app
     */
    public function __construct($task, $app)
    {
        $this->setName($task->getName());
        $this->setDescription($task->getDescription());
        $this->task = $task;

        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
//        $stage = $input->getArgument('stage');
//        $server = $input->getArgument('server');

        $context = new Context();

        $this->task->run($context);
    }


}
