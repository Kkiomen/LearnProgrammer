<?php

namespace App\CoreAssistant\Adapter\Repository\Interface;

interface RepositorySqlInterface
{
    public function select(string $selectSQL): array;
}
