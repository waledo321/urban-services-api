<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Building extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'real_estate_number',
        'license_number',
        'total_floors',
        'has_basement',
        'has_garage',
        'ownership_type',
        'is_illegal',
        'coordinates',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_floors' => 'integer',
            'has_basement' => 'boolean',
            'has_garage' => 'boolean',
            'is_illegal' => 'boolean',
            'coordinates' => 'array',
        ];
    }

    public function apartments(): HasMany
    {
        return $this->hasMany(Apartment::class);
    }

    public function families(): HasManyThrough
    {
        return $this->hasManyThrough(Family::class, Apartment::class);
    }

    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class);
    }
}
