<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        SubscriptionPlan::firstOrCreate([
            'code' => 'swego_admin',
        ], [
            'name' => 'Подписка для администратора Szego',
            'price' => 390.00,
            'currency' => 'RUB',
            'description' => 'Подписка для администрирования каталога swego',
        ]);
    }
}
