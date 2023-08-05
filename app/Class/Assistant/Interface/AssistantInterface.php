<?php

namespace App\Class\Assistant\Interface;

use App\Class\Assistant\Enum\AssistantType;
use App\Class\PromptHistory\PromptHistoryDTO;
use App\Core\Interfaces\DTOInterface;

interface AssistantInterface extends DTOInterface
{
    public function getImgUrl(): ?string;
    public function setImgUrl(?string $imgUrl): self;
    public function getName(): ?string;
    public function setName(?string $name): self;
    public function getShortName(): ?string;
    public function setShortName(?string $shortName): self;
    public function getPromptHistory(): ?PromptHistoryDTO;
    public function setPromptHistory(?PromptHistoryDTO $promptHistory): self;
    public function getSort(): ?int;
    public function setSort(?int $sort): self;
    public function getType(): AssistantType;
    public function setType(AssistantType $type): self;
    public function getPublic(): ?bool;
    public function setPublic(?bool $public): self;
}
