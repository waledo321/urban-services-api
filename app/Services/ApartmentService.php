<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Apartment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ApartmentService
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Apartment::query()
            ->with('building')
            ->latest('id')
            ->paginate($perPage);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): Apartment
    {
        return Apartment::query()->create($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(Apartment $apartment, array $data): Apartment
    {
        $apartment->update($data);

        return $apartment->refresh();
    }

    public function delete(Apartment $apartment): void
    {
        $apartment->delete();
    }
}