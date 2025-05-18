<?php

namespace App\Services\Swego;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class SwegoApiService
{
    protected array $items = [];
    protected ?string $lastTimestamp = null;
    protected ?string $shopName = null;

    /**
     * @throws ConnectionException
     */
    public function fetchWithCookie(
        string $cookie,
        string $shopId,
        string $shopName,
        array $filters = [],
        string $endpoint = 'moments',
        ?string $after = null // это timestamp
    ): array {
        // Важно: соблюдаем нужный порядок
        $queryParams = [
            'searchValue' => '',
            'searchImg' => '',
            'noCache' => 0,
        ];

        if ($after) {
            $queryParams['slipType'] = 1;
            $queryParams['timestamp'] = $after;
        }

        $queryParams += [
            'requestDataType' => '',
            'link_type' => 'pc_home',
            'shop_id' => $shopId,
            'shop_name' => $shopName,
        ];

        $url = "https://www.szwego.com/album/{$endpoint}?" . http_build_query($queryParams);

        $response = Http::withHeaders([
            'Cookie' => $cookie,
            'Accept' => 'application/json',
        ])
            ->timeout(config('swego.timeout'))
            ->get($url);

        $data = $response->json();

        $this->validateApiResponse($data);

        $this->items = array_map([$this, 'processCatalogItem'], $data['result']['items']);

        $this->lastTimestamp = end($this->items)['timestamp'] ?? null;

        return [
            'items' => $this->items,
            'next_timestamp' => $this->lastTimestamp,
        ];
    }



    protected function validateApiResponse(array $data): void
    {
        if (!isset($data['result']['items']) || !is_array($data['result']['items'])) {
            throw new \RuntimeException('Некорректный ответ от Swego API');
        }
    }

    protected function processCatalogItem(array $item): array
    {
        return [
            'id' => $item['goods_id'] ?? null,
            'image' => is_array($item['imgsSrc'] ?? null) ? $item['imgsSrc'][0] ?? null : $item['imgsSrc'],
            'icon' => $item['user_icon'] ?? null,
            'timestamp' => $item['time_stamp'] ?? null,
        ];
    }

}


