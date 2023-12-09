<?php

namespace App\CoreAssistant\Adapter\Repository\FirebirdRepository;

use App\CoreAssistant\Adapter\Repository\Interface\RepositorySqlInterface;
use Illuminate\Support\Facades\DB;

class FirebirdSqlRepository implements RepositorySqlInterface
{
    public function select(string $selectSQL): array
    {
        $results = DB::connection('firebird')->select($selectSQL);

        // Must convert to array because the result is stdClass
        return json_decode(json_encode($results), true);
    }
}
