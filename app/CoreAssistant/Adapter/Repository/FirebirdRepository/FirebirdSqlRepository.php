<?php

namespace App\CoreAssistant\Adapter\Repository\FirebirdRepository;

use App\CoreAssistant\Adapter\Repository\Interface\RepositorySqlInterface;
use Illuminate\Support\Facades\DB;

class FirebirdSqlRepository implements RepositorySqlInterface
{
    public function select(string $selectSQL): array
    {
        return DB::connection('firebird')->select($selectSQL);
    }
}
