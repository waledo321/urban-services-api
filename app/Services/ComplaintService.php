<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Complaint;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ComplaintService
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Complaint::query()
            ->with('family')
            ->latest('id')
            ->paginate($perPage);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): Complaint
    {
        if (! array_key_exists('status', $data)) {
            $data['status'] = 'pending';
        }

        return Complaint::query()->create($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(Complaint $complaint, array $data): Complaint
    {
        $complaint->update($data);

        return $complaint->refresh();
    }

    public function delete(Complaint $complaint): void
    {
        $complaint->delete();
    }
}