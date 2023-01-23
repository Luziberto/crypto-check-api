<?php

namespace App\Http\Resources;

use App\Constants\CurrencyConstants;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetHistoryResource extends JsonResource
{
    public function toArray($request)
    {
        return  [
            'name'  => $this['name'],
            'image' => [
                'thumb' => $this['image']['thumb'],
                'small' => $this['image']['small']
            ],
            'market_data' => [
                [
                    'price' => currencyFormat($this['market_data']['current_price'][CurrencyConstants::BRL], CurrencyConstants::PT_BR_CURRENCY),
                    'total_volume' => currencyFormat($this['market_data']['total_volume'][CurrencyConstants::BRL], CurrencyConstants::PT_BR_CURRENCY),
                    'fiat' => strToUpper(CurrencyConstants::BRL)
                ],
                [
                    'price' => currencyFormat($this['market_data']['current_price'][CurrencyConstants::USD], CurrencyConstants::EN_US_CURRENCY),
                    'total_volume' => currencyFormat($this['market_data']['total_volume'][CurrencyConstants::USD], CurrencyConstants::EN_US_CURRENCY),
                    'fiat' => strToUpper(CurrencyConstants::USD)
                ]
            ],
        ];
    }
}
