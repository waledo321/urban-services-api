<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Requests\Building\UpdateBuildingRequest;
use App\Http\Resources\BuildingResource;
use App\Models\Building;
use App\Services\BuildingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuildingController extends BaseApiController
{
    public function __construct(private readonly BuildingService $buildingService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->integer('per_page', 15);

        return $this->successResponse(
            'Buildings retrieved successfully.',
            BuildingResource::collection($this->buildingService->paginate($perPage))
        );
    }

    public function store(StoreBuildingRequest $request): JsonResponse
    {
        $building = $this->buildingService->create($request->validated());

        return $this->successResponse('Building created successfully.', new BuildingResource($building), 201);
    }

    public function show(Building $building): JsonResponse
    {
        $building->load('apartments');

        return $this->successResponse('Building retrieved successfully.', new BuildingResource($building));
    }

    public function update(UpdateBuildingRequest $request, Building $building): JsonResponse
    {
        $building = $this->buildingService->update($building, $request->validated());

        return $this->successResponse('Building updated successfully.', new BuildingResource($building));
    }

    public function destroy(Building $building): JsonResponse
    {
        $this->buildingService->delete($building);

        return $this->successResponse('Building deleted successfully.');
    }
}