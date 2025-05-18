<?php

namespace App\Livewire\Account;

use App\Models\SwegoSettings;

class SwegoSettingsForm extends BaseAccountData
{
    public $adminSettings = [
        'cookie' => '',
        'album_id' => '',
        'shop_name' => ''
    ];

    public $urlSettings = [
        'url' => '',
        'album_id' => '',
        'shop_name' => ''
    ];

    public function mount(): void
    {
        $this->loadSharedData(auth()->id());
        $this->loadExistingSettings();
    }

    protected function loadExistingSettings(): void
    {
        foreach ($this->subscriptions as $subscription) {
            if (!isset($subscription['swego_settings'])) continue;

            $settings = $subscription['swego_settings'];
            $code = $subscription['platform']['code'];

            if ($code === 'swego_admin') {
                $this->adminSettings = [
                    'cookie' => $settings['cookie'] ?? '',
                    'album_id' => $settings['album_id'] ?? '',
                    'shop_name' => $settings['shop_name'] ?? ''
                ];
            } elseif ($code === 'swego_url') {
                $this->urlSettings = [
                    'url' => $settings['url'] ?? '',
                    'album_id' => $settings['album_id'] ?? '',
                    'shop_name' => $settings['shop_name'] ?? ''
                ];
            }
        }
    }

    public function save(): void
    {
        $this->validateAll();

        try {
            foreach ($this->subscriptions as $subscription) {
                if (!in_array($subscription['platform']['code'], ['swego_admin', 'swego_url'])) {
                    continue;
                }

                $this->saveSubscriptionSettings($subscription);
            }

            session()->flash('message', 'Настройки успешно сохранены');
            $this->redirect(route('account.swego.settings'));
        } catch (\Exception $e) {
            session()->flash('error', 'Ошибка при сохранении настроек: '.$e->getMessage());
        }
    }

    protected function validateAll(): void
    {
        if ($this->hasAdminSubscription) {
            $this->validate([
                'adminSettings.cookie' => 'required|string',
                'adminSettings.album_id' => 'required|string',
                'adminSettings.shop_name' => 'required|string|max:255'
            ]);
        }

        if ($this->hasUrlSubscription) {
            $this->validate([
                'urlSettings.url' => 'required|url|max:255',
                'urlSettings.album_id' => 'required|string',
                'urlSettings.shop_name' => 'required|string|max:255'
            ]);
        }
    }

    protected function saveSubscriptionSettings(array $subscription): void
    {
        $code = $subscription['platform']['code'];
        $settings = $code === 'swego_admin' ? $this->adminSettings : $this->urlSettings;

        $data = [
            'album_id' => $settings['album_id'],
            'shop_name' => $settings['shop_name'],
            'user_id' => auth()->id()
        ];

        if ($code === 'swego_admin') {
            $data['cookie'] = $settings['cookie'];
        } else {
            $data['url'] = $settings['url'];
        }

        SwegoSettings::updateOrCreate(
            ['subscription_id' => $subscription['id']],
            $data
        );
    }

    public function render()
    {
        return view('livewire.account.swego-settings-form', [
            'showAdminForm' => $this->hasAdminSubscription,
            'showUrlForm' => $this->hasUrlSubscription,
        ])->layout('layouts.app');
    }
}
