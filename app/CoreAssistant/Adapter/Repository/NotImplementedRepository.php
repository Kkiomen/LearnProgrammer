<?php

namespace App\CoreAssistant\Adapter\Repository;

use App\CoreAssistant\Adapter\Repository\Interface\RepositoryInterface;
use App\CoreAssistant\Core\Collection\Collection;
use App\CoreAssistant\Core\Domain\Abstract\Entity;

class NotImplementedRepository implements RepositoryInterface
{
    public function findAll(): ?Collection
    {
        throw new \Exception('Not implemented');
    }

    public function findById(int $id): ?Entity
    {
        throw new \Exception('Not implemented');
    }

    public function findBy(array $criteria): ?Collection
    {
        throw new \Exception('Not implemented');
    }

    public function findOneBy(array $criteria): ?Entity
    {
        throw new \Exception('Not implemented');
    }

    public function exists(array $criteria): bool
    {
        throw new \Exception('Not implemented');
    }

    public function save(Entity $entity): Entity|bool
    {
        throw new \Exception('Not implemented');
    }
}
