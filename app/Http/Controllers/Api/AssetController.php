<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetIndexRequest;
use App\Http\Resources\AssetIndexCollection;
use App\Services\Asset\AssetServiceInterface;

class AssetController extends Controller
{
    private $assetService;

    public function __construct(AssetServiceInterface $assetService) {
        $this->assetService = $assetService;
    }

    public function index(AssetIndexRequest $request)
    {
        $assets = $this->assetService->search(
            search: $request->get('search') ?? '',
            perPage: $request->get('per_page') ?? '',
            orderBy: $request->get('orderBy') ?? 'id',
            direction: $request->get('direction') ?? 'asc'
        );    

        return response()->json(AssetIndexCollection::make($assets), 200);
    }
}
