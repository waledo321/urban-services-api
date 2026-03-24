<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Family\StoreFamilyRequest;
use App\Http\Requests\Family\UpdateFamilyRequest;
use App\Http\Resources\FamilyResource;
use App\Models\Family;
use App\Services\FamilyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FamilyController extends BaseApiController
{
    public function __construct(private readonly FamilyService $familyService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->integer('per_page', 15);

        return $this->successResponse(
            'Families retrieved successfully.',
            FamilyResource::collection($this->familyService->paginate($perPage))
        );
    }

    public function store(StoreFamilyRequest $request): JsonResponse
    {
        $family = $this->familyService->create($request->validated());

        return $this->successResponse('Family created successfully.', new FamilyResource($family), 201);
    }

    public function show(Family $family): JsonResponse
    {
        $family->load('apartment');

        return $this->successResponse('Family retrieved successfully.', new FamilyResource($family));
    }

    public function update(UpdateFamilyRequest $request, Family $family): JsonResponse
    {
        $family = $this->familyService->update($family, $request->validated());

        return $this->successResponse('Family updated successfully.', new FamilyResource($family));
    }

    public function destroy(Family $family): JsonResponse
    {
        $this->familyService->delete($family);

        return $this->successResponse('Family deleted successfully.');
    }
}