<?php

namespace App\Http\Resources;

use App\Constants\CurrencyConstants;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetWebsocketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'slug' => $this->slug,
            'market_cap' => [
                'brl' => [
                    'current_price' => $this->price_brl ? currencyFormat($this->price_brl, CurrencyConstants::PT_BR_CURRENCY) : '0.00'
                ],
                'usd' => [
                    'current_price' => $this->price_usd ? currencyFormat($this->price_usd, CurrencyConstants::EN_US_CURRENCY) : '0.00'
                ]
            ],
            'price_change_percentage_24h' => $this->price_change_percentage_24h ?? '0.00'
        ];
    }
}
