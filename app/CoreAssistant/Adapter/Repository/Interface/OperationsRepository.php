<?php

namespace App\CoreAssistant\Adapter\Repository\Interface;

interface OperationsRepository
{
    public function exists(array $criteria): bool;
}
