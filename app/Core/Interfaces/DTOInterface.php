<?php

namespace App\Core\Interfaces;

interface DTOInterface
{
    public function getId(): ?int;
    public function setId(int|null $id): self;
}
