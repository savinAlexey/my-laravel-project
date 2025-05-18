<?php

namespace App\Services\Swego;

use App\Services\Swego\Contracts\ProductProviderInterface;
use App\Services\Swego\Providers\AdminProductProvider;
use App\Services\Swego\Providers\UrlProductProvider;

class ProductProviderFactory
{
    public static function fromType(string $type): ProductProviderInterface
    {
        return match ($type) {
            'admin' => new AdminProductProvider(),
            'url'   => new UrlProductProvider(),
            default => throw new \InvalidArgumentException("Unknown type: $type"),
        };
    }
}

