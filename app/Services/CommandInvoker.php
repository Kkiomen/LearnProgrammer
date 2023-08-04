<?php

namespace App\Services;

use App\Abstract\Command;
use App\Abstract\CommandInvokerBase;
use App\Commands\DailyCommand;
use App\Commands\FileCommand;
use App\Commands\JiraCommand;
use App\Commands\TestWiseB2BCommand;
use InvalidArgumentException;

class CommandInvoker extends CommandInvokerBase
{

    /**
     * Register all Commands to check and execute
     * @return void
     */
    function registerCommands(): void
    {
        $this->registerCommand(JiraCommand::class);
        $this->registerCommand(DailyCommand::class);
        $this->registerCommand(FileCommand::class);
        $this->registerCommand(TestWiseB2BCommand::class);
        //$this->registerCommand(NewCommand::class);
    }
}
