<?php

namespace App\CoreAssistant\Adapter\Repository\Interface;

use App\CoreAssistant\Core\Collection\Collection;
use App\CoreAssistant\Core\Domain\Abstract\Entity;

interface GetRepository
{
    public function findAll(): ?Collection;

    public function findById(int $id): ?Entity;

    public function findBy(array $criteria): ?Collection;

    public function findOneBy(array $criteria): ?Entity;
}
