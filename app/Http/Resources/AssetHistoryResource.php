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
                    'price' => $this['market_data']['current_price'][CurrencyConstants::BRL],
                    'total_volume' => $this['market_data']['total_volume'][CurrencyConstants::BRL],
                    'fiat' => strToUpper(CurrencyConstants::BRL)
                ],
                [
                    'price' => $this['market_data']['current_price'][CurrencyConstants::USD],
                    'total_volume' => $this['market_data']['total_volume'][CurrencyConstants::USD]  ,
                    'fiat' => strToUpper(CurrencyConstants::USD)
                ]
            ],
        ];
    }
}
