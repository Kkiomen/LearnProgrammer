<?php

namespace App\CoreAssistant\Core\Domain\Abstract;

use DateTime;

abstract class Entity
{
    private ?int $id = null;

    private ?DateTime $createdAt = null;
    private ?DateTime $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updateAt): self
    {
        $this->updatedAt = $updateAt;

        return $this;
    }
}
