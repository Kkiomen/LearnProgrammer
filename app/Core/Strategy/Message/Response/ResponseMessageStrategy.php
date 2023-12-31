<?php

namespace App\Core\Strategy\Message\Response;

use App\Class\Assistant\Enum\AssistantType;
use App\Class\Message\MessageDTO;
use App\Class\PromptHistory\Prompt;
use App\Core\Enum\ResponseType;

class ResponseMessageStrategy
{
    private ?string $content;
    private Prompt $prompt;
    private ?array $other;
    private ResponseType $responseType;
    private MessageDTO $messageDTO;
    private array $links;
    private ?AssistantType $type;

    public function __construct()
    {
        $this->prompt = new Prompt(null, null);
        $this->responseType = ResponseType::JSON;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getPrompt(): Prompt
    {
        return $this->prompt;
    }

    public function setPrompt(Prompt $prompt): self
    {
        $this->prompt = $prompt;
        return $this;
    }

    public function getOther(): ?array
    {
        return $this->other;
    }

    public function setOther(?array $other): self
    {
        $this->other = $other;
        return $this;
    }

    public function getResponseType(): ResponseType
    {
        return $this->responseType;
    }

    public function setResponseType(ResponseType $responseType): self
    {
        $this->responseType = $responseType;
        return $this;
    }

    public function getMessageDTO(): MessageDTO
    {
        return $this->messageDTO;
    }

    public function setMessageDTO(MessageDTO $messageDTO): self
    {
        $this->messageDTO = $messageDTO;
        return $this;
    }

    public function getLinks(): ?array
    {
        return $this->links ?? null;
    }

    public function setLinks(array $links): self
    {
        $this->links = $links;
        return $this;
    }

    public function getType(): ?AssistantType
    {
        return $this->type;
    }

    public function setType(?AssistantType $type): void
    {
        $this->type = $type;
    }
}
