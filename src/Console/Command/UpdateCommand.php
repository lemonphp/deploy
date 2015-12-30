<?php

namespace Lemon\Deploy\Console\Command;

use Symfony\Component\Console\Command\Command;

class UpdateCommand extends Command
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('update');
        $this->setDescription('Updates app to the latest version');
    }
}
