<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetIndexRequest;
use App\Http\Resources\AssetHistoryResource;
use App\Http\Resources\AssetIndexCollection;
use App\Services\Asset\AssetServiceInterface;
use App\Repositories\Asset\AssetRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AssetController extends Controller
{
    private $assetService;

    public function __construct(AssetServiceInterface $assetService, AssetRepositoryInterface $assetRepository) {
        $this->assetService = $assetService;
    }

    public function index(AssetIndexRequest $request)
    {
        $assets = $this->assetService->search(
            search: $request->get('search') ?? '',
            perPage: $request->get('per_page') ?? '',
            orderBy: $request->get('orderBy') ?? 'price_change_percentage_24h',
            direction: $request->get('direction') ?? 'desc'
        );
                    

        return response()->json(AssetIndexCollection::make($assets), 200);
    }

    public function getAssetHistory($uuid)
    {
        $fields = array_merge(['uuid' => $uuid], request()->all());
        
        $validator = Validator::make($fields, [
            'uuid' => 'required|string|exists:assets,uuid',
            'date' => 'required|date_format:Y-m-d|before_or_equal:'.Carbon::now(),
        ]);

        if (!$validator->passes()) {
            return response()->json($validator->errors()->messages(), 404);
        }
        $data = $this->assetService->getAssetHistory($uuid, request()->input('date'));
        return response()->json(new AssetHistoryResource($data), 200);
    }
    
    
    public function webhook()
    {
      Logger('Entrou no Webhook ' . json_encode(request()->all()));
    }
}
