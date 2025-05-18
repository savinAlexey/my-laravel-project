<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use Symfony\Component\HttpFoundation\Response;

class CheckSwegoSubscription
{
    /**
     * Основной метод Middleware - проверяет наличие активной подписки
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $type Тип подписки ('admin' или 'url')
     * @return Response
     */
    public function handle(Request $request, Closure $next, ?string $type = null): Response
    {
        // Если пользователь не аутентифицирован - редирект на логин
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Проверяем активную подписку (без проверки настроек)
        if (!$this->hasActiveSubscription(Auth::id(), $type)) {
            return redirect()->route('account.subscriptions')
                ->with('error', 'Требуется активная подписка Swego');
        }

        return $next($request);
    }

    /**
     * Проверяет наличие активной подписки указанного типа
     *
     * @param int $userId
     * @param string|null $type
     * @return bool
     */
    protected function hasActiveSubscription(int $userId, ?string $type = null): bool
    {
        $query = Subscription::where('user_id', $userId)
            ->where('active', true)
            ->where('ends_at', '>', now())
            ->whereHas('platform', function($q) use ($type) {
                $codes = $type
                    ? [$type === 'admin' ? 'swego_admin' : 'swego_url']
                    : ['swego_admin', 'swego_url'];
                $q->whereIn('code', $codes);
            });

        return $query->exists();
    }
}
