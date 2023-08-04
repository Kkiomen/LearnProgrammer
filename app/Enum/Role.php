<?php

namespace App\Enum;

enum Role: int
{
    case USER = 1;
    case ADMINISTRATOR = 2;

    case MODERATOR = 3;

    public static function getRoleByNumber(int $number): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $number) {
                return $case;
            }
        }

        return null;
    }

    public static function getNumberByRole(string $role): ?int
    {
        $role = strtoupper($role);
        foreach (self::cases() as $case) {
            if ($case->name === $role) {
                return $case->value;
            }
        }

        return null;
    }
}
