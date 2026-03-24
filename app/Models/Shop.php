<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shop extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'building_id',
        'owner_family_id',
        'profession',
        'occupancy_type',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'building_id' => 'integer',
            'owner_family_id' => 'integer',
        ];
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function ownerFamily(): BelongsTo
    {
        return $this->belongsTo(Family::class, 'owner_family_id');
    }
}