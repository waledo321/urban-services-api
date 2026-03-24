<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Grave\StoreGraveRequest;
use App\Http\Requests\Grave\UpdateGraveRequest;
use App\Http\Resources\GraveResource;
use App\Models\Grave;
use App\Services\GraveService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GraveController extends BaseApiController
{
    public function __construct(private readonly GraveService $graveService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->integer('per_page', 15);

        return $this->successResponse(
            'Graves retrieved successfully.',
            GraveResource::collection($this->graveService->paginate($perPage))
        );
    }

    public function store(StoreGraveRequest $request): JsonResponse
    {
        $grave = $this->graveService->create($request->validated());

        return $this->successResponse('Grave created successfully.', new GraveResource($grave), 201);
    }

    public function show(Grave $grave): JsonResponse
    {
        $grave->load('family');

        return $this->successResponse('Grave retrieved successfully.', new GraveResource($grave));
    }

    public function update(UpdateGraveRequest $request, Grave $grave): JsonResponse
    {
        $grave = $this->graveService->update($grave, $request->validated());

        return $this->successResponse('Grave updated successfully.', new GraveResource($grave));
    }

    public function destroy(Grave $grave): JsonResponse
    {
        $this->graveService->delete($grave);

        return $this->successResponse('Grave deleted successfully.');
    }
}