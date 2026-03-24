<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('real_estate_number')->unique();
            $table->string('license_number')->unique();
            $table->unsignedSmallInteger('total_floors');
            $table->boolean('has_basement')->default(false);
            $table->boolean('has_garage')->default(false);
            $table->string('ownership_type');
            $table->boolean('is_illegal')->default(false);
            $table->json('coordinates')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
