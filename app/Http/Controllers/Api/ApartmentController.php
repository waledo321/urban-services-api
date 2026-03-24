<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Apartment\StoreApartmentRequest;
use App\Http\Requests\Apartment\UpdateApartmentRequest;
use App\Http\Resources\ApartmentResource;
use App\Models\Apartment;
use App\Services\ApartmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApartmentController extends BaseApiController
{
    public function __construct(private readonly ApartmentService $apartmentService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->integer('per_page', 15);

        return $this->successResponse(
            'Apartments retrieved successfully.',
            ApartmentResource::collection($this->apartmentService->paginate($perPage))
        );
    }

    public function store(StoreApartmentRequest $request): JsonResponse
    {
        $apartment = $this->apartmentService->create($request->validated());

        return $this->successResponse('Apartment created successfully.', new ApartmentResource($apartment), 201);
    }

    public function show(Apartment $apartment): JsonResponse
    {
        $apartment->load(['building', 'families']);

        return $this->successResponse('Apartment retrieved successfully.', new ApartmentResource($apartment));
    }

    public function update(UpdateApartmentRequest $request, Apartment $apartment): JsonResponse
    {
        $apartment = $this->apartmentService->update($apartment, $request->validated());

        return $this->successResponse('Apartment updated successfully.', new ApartmentResource($apartment));
    }

    public function destroy(Apartment $apartment): JsonResponse
    {
        $this->apartmentService->delete($apartment);

        return $this->successResponse('Apartment deleted successfully.');
    }
}