<?php

namespace App\Models;

use App\Events\CryptoUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Asset extends Model
{
    use Uuids;
    use HasFactory;

    protected $casts = [
        'market_90_days_brl' => 'array',
        'market_90_days_usd' => 'array'
    ];

    protected $fillable = [
        'name',
        'slug',
        'symbol',
        'price_brl',
        'price_usd',
        'market_90_days_brl',
        'market_90_days_usd',
        'coin_base',
        'external_id',
    ];
}
