<?php

namespace App\Livewire\Account;

use App\Models\Subscription;
use Livewire\Component;

abstract class BaseAccountData extends Component
{
    public array $subscriptions = [];

    public bool $showSwegoSetupButtonSwego = false;
    public bool $showSwegoSetupButton = false;

    public bool $hasAdminSubscription = false;

    public bool $hasUrlSubscription = false;

    public array $availableSwegoTypes = [];

    public string $availableSwegoType = '';


    /**
     * Загружает общие данные аккаунта пользователя, включая активные подписки
     * и флаг необходимости настройки Swego.
     *
     * @param int $userId ID пользователя для загрузки данных
     * @return void
     */
    /**
     * Загружает и обрабатывает данные подписок пользователя для отображения в интерфейсе
     * Устанавливает флаги для управления отображением элементов UI
     *
     * @param int $userId ID пользователя
     * @return void
     */
    protected function loadSharedData(int $userId): void
    {
        // 1. ЗАГРУЗКА ДАННЫХ ПОДПИСОК
        // Используем жадную загрузку (eager loading) для оптимизации запросов
        $data = Subscription::with([
            // Загружаем только необходимые поля связанной модели Platform
            'platform:id,name,code',

            // Загружаем настройки Swego только для текущего пользователя
            'swegoSettings' => fn($q) => $q->where('user_id', $userId)
        ])
            // Фильтрация подписок:
            ->where('user_id', $userId)       // Только подписки текущего пользователя
            ->where('active', true)           // Только активные подписки
            ->where('ends_at', '>', now())    // Подписки с неистекшим сроком действия
            ->orderBy('ends_at', 'desc')      // Сортировка по дате окончания (свежие сверху)
            ->get();                          // Выполнение запроса

        // 2. ПРЕОБРАЗОВАНИЕ ДАННЫХ И ПРОВЕРКА НАСТРОЕК
        $this->subscriptions = $data->map(function($subscription) {
            // Определяем, относится ли подписка к платформе Swego
            $isSwego = in_array($subscription->platform->code, ['swego_admin', 'swego_url']);
            $settings = $subscription->swegoSettings;

            // Проверка полноты настроек в зависимости от типа платформы
            $settingsValidAdmin = false;
            $settingsValidUrl = false;
            if ($isSwego && $settings) {
                // Для swego_admin проверяем наличие всех обязательных полей
                if ($subscription->platform->code === 'swego_admin') {
                    $settingsValidAdmin = !empty($settings->album_id)
                        && !empty($settings->shop_name)
                        && !empty($settings->cookie);
                }
                // Для swego_url проверяем другой набор обязательных полей
                else {
                    $settingsValidUrl = !empty($settings->album_id)
                        && !empty($settings->shop_name)
                        && !empty($settings->url);
                }
            }

            // Формируем массив данных для каждой подписки
            return [
                'id' => $subscription->id,                    // ID подписки
                'ends_at' => $subscription->ends_at,          // Дата окончания действия
                'platform' => $subscription->platform,        // Данные платформы

                // Флаг: нужно ли показывать кнопку настройки
                // (для Swego-подписок)
                'show_setup_button_swego' => $isSwego,

                // (для Swego-подписок без настроек)
                'show_setup_button' => $isSwego && $settings === null,

                // Флаг: заполнены ли все обязательные настройки с подпиской swego_admin
                'settings_valid_admin' => $settingsValidAdmin,

                // Флаг: заполнены ли все обязательные настройки с подпиской swego_url
                'settings_valid_url' => $settingsValidUrl,

                //Флаг: для передачи настроек в форму
                'swego_settings' => $settings,

            ];
        })->toArray();  // Преобразуем коллекцию в массив

        // 3. УСТАНОВКА ФЛАГОВ ДЛЯ УПРАВЛЕНИЯ ИНТЕРФЕЙСОМ

        $swegoSubs = collect($this->subscriptions)->whereIn('platform.code', ['swego_admin', 'swego_url']);

        $this->showSwegoSetupButtonSwego = $swegoSubs->isNotEmpty();
        $this->showSwegoSetupButton = $swegoSubs->contains('show_setup_button', true);

        //Флаг: Определяем типы доступных подписок
        $this->availableSwegoTypes = $swegoSubs->pluck('platform.code')->all();
        $this->hasAdminSubscription = in_array('swego_admin', $this->availableSwegoTypes);
        $this->hasUrlSubscription = in_array('swego_url', $this->availableSwegoTypes);

        if ($this->hasAdminSubscription) {
            $this->availableSwegoType = 'admin';
        } elseif ($this->hasUrlSubscription) {
            $this->availableSwegoType = 'url';
        }

        //Флаг: есть ли хотя бы одна подписка на swego
        $this->showSwegoSetupButtonSwego = collect($this->subscriptions)
            ->contains('show_setup_button_swego', true);

        // Флаг: есть ли хотя бы одна подписка, требующая настройки
        $this->showSwegoSetupButton = collect($this->subscriptions)
            ->contains('show_setup_button', true);

    }


}
