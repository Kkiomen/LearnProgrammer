<?php

namespace App\Interfaces;

interface CommandInterface
{
    public function execute($params, $content): array;
}
