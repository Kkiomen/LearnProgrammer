<?php

namespace App\CoreAssistant\Core\Patterns\Builder;

use App\CoreAssistant\Core\Domain\Abstract\Entity;

interface BuilderEntity
{
    public function reset(): void;
    public function build(): Entity;
}
