<?php

namespace App\Services\Swego\Providers;

use App\Models\Subscription;
use App\Services\Swego\Contracts\ProductProviderInterface;
use App\Services\Swego\SwegoApiService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Auth;

class AdminProductProvider implements ProductProviderInterface
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
            ->whereHas('platform', fn($q) => $q->where('code', 'swego_admin'))
            ->with('swegoSettings')
            ->firstOrFail();

        return [
            'cookie'     => $subscription->swegoSettings->cookie ?? '',
            'shop_id'    => $subscription->swegoSettings->album_id ?? '',
            'shop_name'  => $subscription->swegoSettings->shop_name ?? '',
        ];
    }

    /**
     * @throws ConnectionException
     */
    public function fetch(array $filters = [], string $endpoint = 'moments', ?string $after = null): array
    {
        $settings = $this->getSettings();

        return $this->api->fetchWithCookie(
            cookie: $settings['cookie'],
            shopId: $settings['shop_id'],
            shopName: $settings['shop_name'],
            filters: $filters,
            endpoint: $endpoint,
            after: $after // <-- вот сюда
        );
    }
}




