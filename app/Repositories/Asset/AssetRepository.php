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

    public function getAssetsByExternalIds(array $externalIds)
    {
        return Asset::whereIn('external_id', $externalIds)->get();
    }

    public function syncAssetsByExternalIds(array $coins)
    {
        foreach ($coins as $coin) {
            $asset = Asset::find($coin['coin_gecko_id']);

            if (!$asset) {
                Log::error("[AssetRepository] Asset not found", ['external_id' => $coin['external_id']]);
                continue;
            }

            $asset->update(['price' => $asset['price']]);
        }
    }
}
