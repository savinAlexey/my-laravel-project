<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $fillable = ['name', 'code', 'description', 'icon'];

    public function subscriptionPlans()
    {
        return $this->hasMany(SubscriptionPlan::class);
    }
}

