<?php

namespace App\CoreAssistant\Config\TableToPrompts\TableConfigHelper;

enum TableConfigFieldType: string
{
    case VARCHAR = 'v';
    case INTEGER = 'i';
    case DATE = 'd';
    case NUMERIC = 'n';

    public static function getFieldTypesToPrompt(): string
    {
        return self::getFieldTypeToPrompt(self::VARCHAR) . ', ' .
            self::getFieldTypeToPrompt(self::INTEGER) . ', ' .
            self::getFieldTypeToPrompt(self::DATE) . ', ' .
            self::getFieldTypeToPrompt(self::NUMERIC);
    }

    public static function getFieldTypeToPrompt(TableConfigFieldType $type): string
    {
        return '('. $type->value .') - ' . ucfirst(strtolower($type->name));
    }
}
