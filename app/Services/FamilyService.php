<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Family;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FamilyService
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Family::query()
            ->with('apartment')
            ->latest('id')
            ->paginate($perPage);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): Family
    {
        return Family::query()->create($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(Family $family, array $data): Family
    {
        $family->update($data);

        return $family->refresh();
    }

    public function delete(Family $family): void
    {
        $family->delete();
    }
}