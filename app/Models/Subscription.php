<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subscription extends Model
{
    protected $casts = [
        'active' => 'boolean',
        'ends_at' => 'datetime'
    ];

    // Отношение к платформе
    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    // Отношение к настройкам Swego
    public function swegoSettings(): HasOne
    {
        return $this->hasOne(SwegoSettings::class);
    }
}


