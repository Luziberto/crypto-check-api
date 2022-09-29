<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Asset extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'symbol',
        'price',
        'coin_base',
        'external_id',
    ];
}
