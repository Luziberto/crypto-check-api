<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetIndexRequest;
use App\Http\Resources\AssetHistoryResource;
use App\Http\Resources\AssetIndexCollection;
use App\Services\Asset\AssetServiceInterface;
use App\Http\Resources\AssetResource;
use App\Models\Asset;
use App\Repositories\Asset\AssetRepositoryInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AssetController extends Controller
{
    private $assetService;
    private $assetRepository;

    public function __construct(AssetServiceInterface $assetService, AssetRepositoryInterface $assetRepository) {
        $this->assetService = $assetService;
        $this->assetRepository = $assetRepository;
    }

    public function index(AssetIndexRequest $request, Asset $asset)
    {
        $externalIds = $this->assetRepository->getAllExternalId()->pluck('external_id')->toArray();
        logger($externalIds);
        $search = $request->get('search');
        $orderBy = $request->get('orderBy') ?? 'price_change_percentage_24h';
        $direction = $request->get('direction') ?? 'desc';
        $perPage = $request->get('per_page') ?? 10;

        $assets = $asset
                    ->when($search, fn (Builder $query) => $query->where(DB::raw('lower(name)'),'LIKE', "%$search%"))
                    ->orderBy($request->get('orderBy', $orderBy), $request->get('direction', $direction))
                    ->paginate($request->get('per_page', $perPage));
                    

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

    public function searchAssets()
    {
        $validator = Validator::make(request()->all(), [
            'search' => 'required|string|min:1'
        ]);

        if (!$validator->passes()) {
            return response()->json($validator->errors()->messages(), 404);
        }

        $search = request()->input('search');

        $data = $this->assetService->getAssets($search);
        return response()->json(AssetResource::collection($data), 200); 
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
