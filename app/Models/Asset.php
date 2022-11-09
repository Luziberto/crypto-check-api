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

    protected $dispatchesEvents = [
        'updated' => CryptoUpdated::class
    ];

    protected $fillable = [
        'name',
        'slug',
        'symbol',
        'price_brl',
        'price_usd',
        'coin_base',
        'external_id',
    ];
}
