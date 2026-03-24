<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Building;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BuildingService
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Building::query()
            ->latest('id')
            ->paginate($perPage);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): Building
    {
        return Building::query()->create($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(Building $building, array $data): Building
    {
        $building->update($data);

        return $building->refresh();
    }

    public function delete(Building $building): void
    {
        $building->delete();
    }
}