<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Family extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'apartment_id',
        'family_book',
        'health_status',
        'living_status',
        'last_aid_date',
        'unemployed_count',
        'students_count',
        'occupancy_type',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'apartment_id' => 'integer',
            'last_aid_date' => 'date',
            'unemployed_count' => 'integer',
            'students_count' => 'integer',
        ];
    }

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class, 'owner_family_id');
    }

    public function graves(): HasMany
    {
        return $this->hasMany(Grave::class);
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }
}
