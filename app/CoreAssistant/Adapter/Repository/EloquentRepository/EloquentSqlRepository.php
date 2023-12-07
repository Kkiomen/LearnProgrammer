<?php

namespace App\CoreAssistant\Adapter\Repository\EloquentRepository;

use App\CoreAssistant\Adapter\Repository\Interface\RepositorySqlInterface;
use Illuminate\Support\Facades\DB;

class EloquentSqlRepository implements RepositorySqlInterface
{
    public function select(string $selectSQL): array
    {
        return DB::select(DB::raw($selectSQL));
    }
}
