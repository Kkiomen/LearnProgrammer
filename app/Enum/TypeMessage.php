<?php

namespace App\Enum;

enum TypeMessage: string
{
    case COMMAND = 'command';
    case TEXT = 'text';
    case SNIPPET = 'snippet';
    case IMAGE = 'image';

    public function toArray(): array
    {
        return [
            self::COMMAND->value,
            self::TEXT->value,
            self::SNIPPET->value,
            self::IMAGE->value,
        ];
    }
}
