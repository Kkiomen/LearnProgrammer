<?php

namespace App\CoreAssistant\Adapter\Repository\Interface;

use App\CoreAssistant\Core\Domain\Abstract\Entity;

interface SaveRepository
{
    public function save(Entity $entity): bool;
}
