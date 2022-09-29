<?php

namespace App\Exceptions;

use Exception;

class CoinGeckoHttpException extends Exception
{
    public function __construct(string $message = 'coin_gecko_error')
    {
        parent::__construct($message);
    }
}
