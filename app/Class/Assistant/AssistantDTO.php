<?php

namespace App\Class\Assistant;

use App\Class\Assistant\Enum\AssistantType;
use App\Class\Assistant\Interface\AssistantInterface;
use App\Class\PromptHistory\PromptHistoryDTO;
use App\Core\Abstract\Dto;

class AssistantDTO extends Dto implements AssistantInterface
{
    private ?string $imgUrl;
    private ?string $name;
    private ?string $shortName;
    private ?PromptHistoryDTO $promptHistory;
    private ?int $sort;
    private ?AssistantType $type;
    private ?bool $public;

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

    public function getPromptHistory(): ?PromptHistoryDTO
    {
        return $this->promptHistory;
    }

    public function setPromptHistory(?PromptHistoryDTO $promptHistory): self
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
        $this->sort = $sort;
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
}
