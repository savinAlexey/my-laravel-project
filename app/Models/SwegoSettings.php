<?php

// app/Models/SwegoSettings.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SwegoSettings extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_id',
        'cookie',
        'url',
        'album_id',
        'shop_name'
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}


