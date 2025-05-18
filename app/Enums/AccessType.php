<?php

namespace App\Enums;

enum AccessType: string
{
    case ADMIN = 'admin';
    case URL = 'url';

    public static function tryFromName(string $name): ?self
    {
        return match(strtolower($name)) {
            'admin' => self::ADMIN,
            'url' => self::URL,
            default => null
        };
    }
}

