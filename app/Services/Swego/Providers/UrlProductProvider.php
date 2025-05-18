<?php

namespace App\Services\Swego\Providers;

use App\Models\Subscription;
use App\Services\Swego\Contracts\ProductProviderInterface;
use App\Services\Swego\SwegoApiService;
use Illuminate\Support\Facades\Auth;

class UrlProductProvider implements ProductProviderInterface
{
    protected SwegoApiService $api;

    public function __construct()
    {
        $this->api = new SwegoApiService();
    }

    protected function getSettings(): array
    {
        $subscription = Subscription::query()
            ->where('user_id', Auth::id())
            ->whereHas('platform', fn($q) => $q->where('code', 'swego_url'))
            ->with('swegoSettings')
            ->firstOrFail();

        return [
            'url'        => $subscription->swegoSettings->url ?? '',
            'shop_id'    => $subscription->swegoSettings->album_id ?? '',
            'shop_name'  => $subscription->swegoSettings->shop_name ?? '',
        ];
    }

    public function fetch(array $filters = []): array
    {
//        $settings = $this->getSettings();
//
//        return $this->api->fetchByUrl(
//            url: $settings['url'],
//            albumId: $settings['shop_id'],
//            shopName: $settings['shop_name'],
//            filters: $filters
//        );
    }
}

