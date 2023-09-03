<?php

namespace App\Class\Assistant\Interface;

use App\Class\Assistant\Enum\AssistantType;
use App\Class\PromptHistory\Prompt;
use App\Core\Interfaces\DTOInterface;

interface AssistantInterface extends DTOInterface
{
    public function getImgUrl(): ?string;
    public function setImgUrl(?string $imgUrl): self;
    public function getName(): ?string;
    public function setName(?string $name): self;
    public function getShortName(): ?string;
    public function setShortName(?string $shortName): self;
    public function getPromptHistory(): ?Prompt;
    public function setPromptHistory(?Prompt $promptHistory): self;
    public function getSort(): ?int;
    public function setSort(?int $sort): self;
    public function getType(): AssistantType;
    public function setType(AssistantType $type): self;
    public function getPublic(): ?bool;
    public function setPublic(?bool $public): self;
    public function getMemoryCollection(): ?string;
    public function setMemoryCollection(?string $memoryCollection): self;

    public function setStartMessage(?string $startMessage): self;

    public function getStartMessage(): ?string;
}
