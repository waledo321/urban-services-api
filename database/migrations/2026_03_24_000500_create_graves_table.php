<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('graves', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('family_id')
                ->constrained('families')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('block_name');
            $table->unsignedInteger('row_number');
            $table->enum('status', ['available', 'occupied'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('graves');
    }
};
