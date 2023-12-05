<?php

namespace App\CoreAssistant\Service\MessageInterpreter;

use App\CoreAssistant\Abstract\Event;

class InterpretationDetails
{
    private string $type = 'basic';
    private ?Event $interpretedClass = null;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getInterpretedClass(): ?Event
    {
        return $this->interpretedClass;
    }

    public function setInterpretedClass(?Event $interpretedClass): self
    {
        $this->interpretedClass = $interpretedClass;

        return $this;
    }
}
