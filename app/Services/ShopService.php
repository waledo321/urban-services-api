<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Shop;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ShopService
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Shop::query()
            ->with(['building', 'ownerFamily'])
            ->latest('id')
            ->paginate($perPage);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): Shop
    {
        return Shop::query()->create($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(Shop $shop, array $data): Shop
    {
        $shop->update($data);

        return $shop->refresh();
    }

    public function delete(Shop $shop): void
    {
        $shop->delete();
    }
}