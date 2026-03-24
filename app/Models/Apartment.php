<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apartment extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'building_id',
        'floor_type',
        'water_meter',
        'electricity_meter',
        'landline',
        'is_sealed',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'building_id' => 'integer',
            'is_sealed' => 'boolean',
        ];
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function families(): HasMany
    {
        return $this->hasMany(Family::class);
    }
}
