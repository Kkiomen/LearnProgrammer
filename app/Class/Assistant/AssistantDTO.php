<?php

namespace App\Class\Assistant;

use App\Class\Assistant\Enum\AssistantType;
use App\Class\Assistant\Interface\AssistantInterface;
use App\Class\PromptHistory\Prompt;
use App\Core\Core\Abstract\Dto;

class AssistantDTO extends Dto implements AssistantInterface
{
    private ?string $imgUrl;
    private ?string $name;
    private ?string $shortName;
    private ?Prompt $promptHistory;
    private ?int $sort;
    private ?AssistantType $type;
    private ?bool $public;

    private ?string $startMessage;

    private ?string $memoryCollection;

    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(?string $imgUrl): self
    {
        $this->imgUrl = $imgUrl;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(?string $shortName): self
    {
        $this->shortName = $shortName;
        return $this;
    }

    public function getPromptHistory(): ?Prompt
    {
        return $this->promptHistory;
    }

    public function setPromptHistory(?Prompt $promptHistory): self
    {
        $this->promptHistory = $promptHistory;
        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(?int $sort): self
    {
        if($sort > 0){
            $this->sort = $sort;
        }
        return $this;
    }

    public function getType(): AssistantType
    {
        return $this->type;
    }

    public function setType(AssistantType $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(?bool $public): self
    {
        $this->public = $public;
        return $this;
    }

    public function getMemoryCollection(): ?string
    {
        return $this->memoryCollection ?? 'memory';
    }

    public function setMemoryCollection(?string $memoryCollection): self
    {
        $this->memoryCollection = $memoryCollection;
        return $this;
    }

    public function getStartMessage(): ?string
    {
        return $this->startMessage;
    }

    public function setStartMessage(?string $startMessage): self
    {
        $this->startMessage = $startMessage;
        return $this;
    }

}
