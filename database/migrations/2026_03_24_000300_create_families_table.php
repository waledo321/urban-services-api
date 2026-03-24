<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('families', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('apartment_id')
                ->constrained('apartments')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('family_book')->unique();
            $table->string('health_status')->nullable();
            $table->string('living_status');
            $table->date('last_aid_date')->nullable();
            $table->unsignedSmallInteger('unemployed_count')->default(0);
            $table->unsignedSmallInteger('students_count')->default(0);
            $table->string('occupancy_type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
