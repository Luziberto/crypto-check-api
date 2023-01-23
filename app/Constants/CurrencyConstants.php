<?php

namespace App\Constants;

class CurrencyConstants {
    const BRL = 'brl';
    const USD = 'usd';

    const PT_BR = 'pt_BR';
    const EN_US = 'en_US';
    
    const PT_BR_CURRENCY = [
        'fiat_symbol' => "R$",
        'fiat_name' => self::BRL,
        'float_separator' => ",",
        'thousand_separator' =>".",
        'locale' => self::PT_BR
    ];

    const EN_US_CURRENCY = [
        'fiat_symbol' => "$",
        'fiat_name' => self::USD,
        'float_separator' => ".",
        'thousand_separator' =>",",
        'locale' => self::EN_US
    ];
    
    const CURRENCY_LOCALE = [
        self::BRL => self::PT_BR,
        self::USD => self::EN_US
    ];

    const LOCALE_CURRENCY = [
        self::PT_BR => self::BRL,
        self::EN_US => self::USD
    ];

}