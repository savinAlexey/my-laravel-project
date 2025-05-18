<?php

namespace App\Livewire\Account;

use App\Services\Swego\ProductProviderFactory;
use Livewire\Component;

class SwegoCatalog extends Component
{
    public string $type;
    public string $endpoint = 'moments';
    public array $products = [];
    public ?string $nextTimestamp = null;

    protected $listeners = ['loadMore'];

    public function mount(string $type): void
    {
        $this->type = $type;
        $this->loadProducts();
    }

    public function loadProducts(array $filters = []): void
    {
        $provider = ProductProviderFactory::fromType($this->type);
        $result = $provider->fetch($filters, $this->endpoint);
        $this->products = $result['items'] ?? [];
        $this->nextTimestamp = $result['next_timestamp'] ?? null;
    }

    public function loadMore(): void
    {
        if (!$this->nextTimestamp) return;

        $provider = ProductProviderFactory::fromType($this->type);
        $result = $provider->fetch([], $this->endpoint, $this->nextTimestamp);

        $this->products = [...$this->products, ...($result['items'] ?? [])];
        $this->nextTimestamp = $result['next_timestamp'] ?? null;
    }

    public function render()
    {
        return view('livewire.account.swego-catalog', [
            'products' => $this->products,
            'hasMore' => !empty($this->nextTimestamp)
        ])->layout('layouts.app');
    }
}


