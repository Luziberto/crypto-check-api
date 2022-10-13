<?php

namespace App\Constants;

class AssetConstants {
    const ETHEREUM = 'ethereum';
    const TERRA = 'terra';
    const BITCOIN = 'bitcoin';
    const DACXI = 'dacxi';
    const COSMOS = 'cosmos hub';
    const DOGECOIN = 'dogecoin';

    const ASSETS_SYMBOLS = [
        self::ETHEREUM => 'eth',
        self::TERRA => 'luna',
        self::BITCOIN => 'btc',
        self::DACXI => 'dacxi',
        self::COSMOS => 'atom',
    ];

    const ASSETS_SLUG = [
        self::ETHEREUM => 'ethereum',
        self::TERRA => 'terra',
        self::BITCOIN => 'bitcoin',
        self::DACXI => 'dacxi',
        self::COSMOS => 'cosmos hub'
    ];
}