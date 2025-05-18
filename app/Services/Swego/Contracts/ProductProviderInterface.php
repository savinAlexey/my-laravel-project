<?php

namespace App\Services\Swego\Contracts;


interface ProductProviderInterface
{
    public function fetch(array $filters = [], string $endpoint = 'moments', ?string $after = null): array;

}

