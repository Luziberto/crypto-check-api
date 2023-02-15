<?php

namespace App\Repositories\Asset;

use App\Constants\CurrencyConstants;
use App\Events\CryptoUpdated;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssetRepository implements AssetRepositoryInterface
{

    protected $entity;

    public function __construct(Asset $asset)
    {
        $this->entity = $asset;
    }

    public function search(string $search, int $perPage, string $orderBy, string $direction): LengthAwarePaginator {
        return $this->entity
                ->when($search, fn (Builder $query) => $query->where(DB::raw('lower(name)'),'LIKE', "%$search%"))
                ->orderBy($orderBy, $direction)
                ->paginate($perPage);
    }
    
    public function getAllExternalId()
    {
        return $this->entity->query()->select('external_id')->get();
    }

    public function getBySlugs(array $slugs)
    {
        return $this->entity->whereIn('slug', $slugs)->get();
    }

    public function getByUuid(string $uuid)
    {
        return $this->entity->where('uuid', $uuid)->first();
    }

    public function getByExternalId(array $externalIds)
    {
        return $this->entity->whereIn('external_id', $externalIds)->get();
    }

    public function syncByExternalIds(array $coins)
    {
        foreach ($coins as $coin) {
            $asset = $this->entity->where('coin_base', $coin['coin_base'])
                        ->where('external_id', $coin['external_id'])
                        ->first();
                                   
            if (!$asset) {
                Log::error("[AssetRepository] Asset not found", ['external_id' => $coin['external_id']]);
                continue;
            }

            $priceUsd = number_format($coin['price_usd'], 12, '.', '');
            $priceBrl = number_format($coin['price_brl'], 12, '.', '');
            
            $asset->price_brl = $priceBrl;
            $asset->price_usd = $priceUsd;
            $asset->price_change_percentage_24h = $coin['price_change_percentage_24h'];

            if ($this->someFieldIsDirty($asset, [
                'price_brl',
                'price_usd',
                'price_change_percentage_24h'
            ])) CryptoUpdated::dispatch($asset);

            $asset->save();
        }
    }
    
    private function someFieldIsDirty(Asset $asset, array $attributes): bool {
        $isDirty = false;
        foreach ($attributes as $attribute) {
            if ($asset->isDirty($attribute)) $isDirty = true;
        }
        return $isDirty;
    }

    public function updateMarketChart(string $externalId, array $market, string $currency)
    {
        $asset = $this->entity->where('external_id', $externalId)
                    ->first();
                                
        if (!$asset) {
            Log::error("[AssetRepository] Asset not found", ['external_id' => $externalId]);
            return;
        }
        
        $asset->update(match ($currency) {
            CurrencyConstants::BRL => ['market_90_days_brl' => $market],
            CurrencyConstants::USD => ['market_90_days_usd' => $market]
        });
    }
}
