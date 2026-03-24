<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Shop\StoreShopRequest;
use App\Http\Requests\Shop\UpdateShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use App\Services\ShopService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShopController extends BaseApiController
{
    public function __construct(private readonly ShopService $shopService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->integer('per_page', 15);

        return $this->successResponse(
            'Shops retrieved successfully.',
            ShopResource::collection($this->shopService->paginate($perPage))
        );
    }

    public function store(StoreShopRequest $request): JsonResponse
    {
        $shop = $this->shopService->create($request->validated());

        return $this->successResponse('Shop created successfully.', new ShopResource($shop), 201);
    }

    public function show(Shop $shop): JsonResponse
    {
        $shop->load(['building', 'ownerFamily']);

        return $this->successResponse('Shop retrieved successfully.', new ShopResource($shop));
    }

    public function update(UpdateShopRequest $request, Shop $shop): JsonResponse
    {
        $shop = $this->shopService->update($shop, $request->validated());

        return $this->successResponse('Shop updated successfully.', new ShopResource($shop));
    }

    public function destroy(Shop $shop): JsonResponse
    {
        $this->shopService->delete($shop);

        return $this->successResponse('Shop deleted successfully.');
    }
}