<?php

namespace App\Constants;

class CoinGeckoErrorConstants
{
    const DEFAULT_ERROR_MESSAGE = 'Something unexpected happened. If the problem persists, contact support.';

    static function getErrorMessage($errorCode)
    {
        return self::DEFAULT_ERROR_MESSAGE;
    }
}
