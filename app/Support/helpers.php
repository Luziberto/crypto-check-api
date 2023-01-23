<?php

use App\Constants\CurrencyConstants;

/**
 * @param float $number
 * @param ?int $decimal
 *
 * @return float
 */

if (!function_exists('roundToDown')) {
    function roundToDown(float $number, int $decimal = 2)
    {
        $divisor = pow(10, $decimal);
        return round(floor($number * $divisor) / $divisor, $decimal);
    }
}

if (!function_exists('minPrecision')) {
    function minPrecision($x, $p)
    {
        $e = pow(10,$p);
        return floor($x*$e)==$x*$e?sprintf("%.${p}f",$x):$x;
    }
}

if (!function_exists('currencyFormat')) {
    function currencyFormat(string $price, array $currencyOptions)
    {   
        $priceArray = explode(CurrencyConstants::EN_US_CURRENCY['float_separator'], $price);
        
        $intPart = number_format((float) $priceArray[0], 2, $currencyOptions['float_separator'], $currencyOptions['thousand_separator']);
        $decimalPart = rtrim($priceArray[1], '0') ? rtrim($priceArray[1], '0') : '00';

        $formatedPrice = rtrim($intPart, '0').$decimalPart;

        return $currencyOptions['fiat_symbol'].' '.$formatedPrice;
    }
}



