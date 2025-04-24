<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Subscription;

class SubscriptionPlan extends Model
{
    protected $table = 'subscription_plans';

    // Указываем атрибуты, которые можно массово заполнять
    protected $fillable = ['name', 'price', 'currency', 'period', 'description', 'platform_id'];

    // Связь с платформой, если нужно
    public function platform()
    {
        return $this->belongsTo(Platform::class); // Связь с платформой
    }

    // Связь с подпиской (если будет необходимость показать связанный план подписки)
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id'); // Если у вас есть связь с подпиской через plan_id
    }
}



