<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apartments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('building_id')
                ->constrained('buildings')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('floor_type');
            $table->string('water_meter')->nullable();
            $table->string('electricity_meter')->nullable();
            $table->string('landline')->nullable();
            $table->boolean('is_sealed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
