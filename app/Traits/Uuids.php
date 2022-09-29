<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Uuids
{
   /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        $keyUuid = 'uuid';
        
        parent::boot();
        static::creating(function ($model) use ($keyUuid) {
            if (empty($model->{$keyUuid})) {
                $model->{$keyUuid} = Str::uuid()->toString();
            }
        });
    }

   /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

   /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}