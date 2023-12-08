<?php

namespace App\CoreAssistant\Dto\MessageProcessor\LoggerSql;

class LoggerSql
{
    private array $queriesSql;

    public function __construct()
    {
        $this->queriesSql = [];
    }

    public function addQuerySql(string $querySql): self
    {
        $this->queriesSql[] = $querySql;

        return $this;
    }

    public function getQueriesSql(): array
    {
        return $this->queriesSql;
    }
}
