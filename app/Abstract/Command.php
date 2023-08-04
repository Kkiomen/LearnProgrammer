<?php

namespace App\Abstract;

use App\Interfaces\CommandInterface;

abstract class Command implements CommandInterface
{
    const CHARACTER_STARTING_COMMAND = '!';
    protected $name;
    protected $params;
    protected $description;
    protected $examples;

    public function getName() {
        return $this->name;
    }

    public function getParams() {
        return $this->params;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getUsageExamples() {
        return $this->examples;
    }
}
