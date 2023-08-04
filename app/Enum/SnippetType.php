<?php

namespace App\Enum;

enum SnippetType: string
{

    case PRIVATE = 'private';
    case GROUP = 'group';
    case SYSTEM = 'system';

    public static function toArray(){
        return [
            self::PRIVATE->value,
            self::GROUP->value,
            self::SYSTEM->value,
        ];
    }

    public static function fromString(string $value): ?self
    {
        try {
            return self::tryFrom($value);
        } catch (\Exception $e) {
            return null;
        }
    }

}
