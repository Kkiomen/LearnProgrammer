<?php

namespace App\Abstract;

use InvalidArgumentException;

abstract class CommandInvokerBase
{
    private $commands;

    public function __construct()
    {
        $this->commands = [];
        $this->registerCommands();
    }

    /**
     * Register new Command
     * @param $commandClass
     * @return void
     */
    public function registerCommand($commandClass)
    {
        $command = new $commandClass;
        if ($command instanceof Command) {
            $this->commands[Command::CHARACTER_STARTING_COMMAND . $command->getName()] = $command;
        } else {
            throw new InvalidArgumentException("Class {$commandClass} must inherit from the Command class.");
        }
    }

    /**
     * Execute command
     * @param $commandString
     * @return array|null
     */
    public function executeCommand($commandString): ?array
    {
        $parsedCommand = $this->parseCommand($commandString);

        if (isset($this->commands[$parsedCommand['action']])) {
            $command = $this->commands[$parsedCommand['action']];
            return $command->execute($parsedCommand['params'], $parsedCommand['content']);
        } else {
            return [
                'message' => "Unknown command: {$parsedCommand['action']}\n"
            ];
        }
    }

    /**
     * Method parses string commands to get the most important information from it
     * @param string $commandString
     * @return array
     */
    function parseCommand(string $commandString): array
    {
        $result = [
            'action' => '',
            'params' => [],
            'content' => ''
        ];

        $pattern = '/^(\!\w+)((?:\s+\-\w+\s+\S+)*)\s+(.*)$/';
        if (preg_match($pattern, $commandString, $matches)) {
            $result['action'] = $matches[1];
            $result['content'] = trim($matches[3]);

            preg_match_all('/\s*\-(\w+)\s+(\S+)/', $matches[2], $paramMatches, PREG_SET_ORDER);
            foreach ($paramMatches as $param) {
                $result['params'][$param[1]] = $param[2];
            }
        }

        return $result;
    }

    /**
     * Return information list about commands
     * @return array
     */
    public function getCommandList(): array{
        $result = [];
        foreach ($this->commands as $command => $class){
            $commandInfo = [
                'description' => $class->getDescription(),
                'params' => $class->getParams(),
                'example' => $class->getUsageExamples()
            ];
            $result[$command] = $commandInfo;
        }
        return $result;
    }

    /**
     * The method is used to record commands
     * @return void
     */
    abstract function registerCommands(): void;
}
