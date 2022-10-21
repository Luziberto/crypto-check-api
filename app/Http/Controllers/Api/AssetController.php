<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssetHistoryResource;
use App\Services\Asset\AssetServiceInterface;
use App\Http\Resources\AssetResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AssetController extends Controller
{
    private $assetService;

    public function __construct(AssetServiceInterface $assetService) {
        $this->assetService = $assetService;
    }

    public function getAssets()
    {
        $validator = Validator::make(request()->all(), [
            'assets' => 'required|array|min:1',
            'assets.*' => 'required|string|exists:assets,slug'
        ]);

        if (!$validator->passes()) {
            return response()->json($validator->errors()->messages(), 404);
        }
        
        $assets = request()->input('assets');

        return response()->json(AssetResource::collection($this->assetService->getAssetsBySlugs($assets)), 200);
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
        logger($data);
        return response()->json(new AssetHistoryResource($data), 200);
    }
    
    
    public function webhook()
    {
      Logger('Entrou no Webhook ' . json_encode(request()->all()));
    }
    // public function getList()
    // {
        
    //     $assets = $this->assetService->getList();

    //     return response()->json($assets, 200);
    // }


    // public function getAssetsPrice()
    // {
    //     $validator = Validator::make(request()->all(), [
    //         'externalIds' => 'required|array|min:1',
    //         'externalIds.*' => 'required|string|exists:assets,external_id'
    //     ]);

    //     if (!$validator->passes()) {
    //         return response()->json($validator->errors()->messages(), 404);
    //     }

    //     $externalIds = request()->input('externalIds');
        
    //     return response()->json($this->assetService->getSimplePrice($externalIds), 200);
    // }

}
