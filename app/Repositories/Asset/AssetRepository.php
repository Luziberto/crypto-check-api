<?php

namespace App\Repositories\Asset;

use App\Models\Asset;
use Illuminate\Support\Facades\Log;

class AssetRepository implements AssetRepositoryInterface
{
    public function getAssetsBySlugs(array $slugs)
    {
        return Asset::whereIn('slug', $slugs)->get();
    }

    public function getAssetsByUuid(string $uuid)
    {
        return Asset::where('uuid', $uuid)->first();
    }

    public function getAssetsByExternalIds(array $externalIds)
    {
        return Asset::whereIn('external_id', $externalIds)->get();
    }

    public function syncAssetsByExternalIds(array $coins)
    {
        foreach ($coins as $coin) {
            $asset = Asset::where('coin_base', $coin['coin_base'])
                        ->where('external_id', $coin['external_id'])
                        ->first();
                                   
            if (!$asset) {
                Log::error("[AssetRepository] Asset not found", ['external_id' => $coin['external_id']]);
                continue;
            }
            logger('antes: '. $asset->price . ' depois: '. number_format($coin['price'], 12, '.', ''));

            $asset->update(['price' => number_format($coin['price'], 12, '.', '')]);
        }
    }

    public function searchAssets(string $search)
    {
        return Asset::when(
            $search,
            fn ($query) => $query->where('name', 'LIKE', "$search%")
        )->paginate();
    }
}
