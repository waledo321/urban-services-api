<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Complaint\StoreComplaintRequest;
use App\Http\Requests\Complaint\UpdateComplaintRequest;
use App\Http\Resources\ComplaintResource;
use App\Models\Complaint;
use App\Services\ComplaintService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComplaintController extends BaseApiController
{
    public function __construct(private readonly ComplaintService $complaintService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->integer('per_page', 15);

        return $this->successResponse(
            'Complaints retrieved successfully.',
            ComplaintResource::collection($this->complaintService->paginate($perPage))
        );
    }

    public function store(StoreComplaintRequest $request): JsonResponse
    {
        $complaint = $this->complaintService->create($request->validated());

        return $this->successResponse('Complaint created successfully.', new ComplaintResource($complaint), 201);
    }

    public function show(Complaint $complaint): JsonResponse
    {
        $complaint->load('family');

        return $this->successResponse('Complaint retrieved successfully.', new ComplaintResource($complaint));
    }

    public function update(UpdateComplaintRequest $request, Complaint $complaint): JsonResponse
    {
        $complaint = $this->complaintService->update($complaint, $request->validated());

        return $this->successResponse('Complaint updated successfully.', new ComplaintResource($complaint));
    }

    public function destroy(Complaint $complaint): JsonResponse
    {
        $this->complaintService->delete($complaint);

        return $this->successResponse('Complaint deleted successfully.');
    }
}