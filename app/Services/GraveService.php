<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Grave;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GraveService
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Grave::query()
            ->with('family')
            ->latest('id')
            ->paginate($perPage);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): Grave
    {
        return Grave::query()->create($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(Grave $grave, array $data): Grave
    {
        $grave->update($data);

        return $grave->refresh();
    }

    public function delete(Grave $grave): void
    {
        $grave->delete();
    }
}