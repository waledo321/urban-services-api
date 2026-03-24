<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('building_id')
                ->constrained('buildings')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('owner_family_id')
                ->constrained('families')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('profession');
            $table->string('occupancy_type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
