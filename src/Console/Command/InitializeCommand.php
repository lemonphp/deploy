<?php

namespace Lemon\Deploy\Console\Command;

use Symfony\Component\Console\Command\Command;

class InitializeCommand extends Command
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('init');
        $this->setDescription('Initialize app');
    }
}
