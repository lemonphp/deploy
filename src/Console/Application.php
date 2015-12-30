<?php

namespace Lemon\Deploy\Console;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Application as Console;

class Application extends Console
{

    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();
        $commands[] = new Command\InitializeCommand();
        $commands[] = new Command\UpdateCommand();

        return $commands;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultHelperSet()
    {
        $helpers = parent::getDefaultHelperSet();
        // TODO: add helper

        return $helpers;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultInputDefinition()
    {
        $inputDefinition = parent::getDefaultInputDefinition();
        $inputDefinition->addOption(new InputOption('--file', '-f', InputOption::VALUE_OPTIONAL, 'Specify deploy script file to load'));

        return $inputDefinition;
    }
}
