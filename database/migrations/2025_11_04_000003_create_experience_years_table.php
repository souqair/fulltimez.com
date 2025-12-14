<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experience_years', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "1 Year", "2 Years"
            $table->string('value'); // e.g., "1 Year", "2 Years" (for matching)
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experience_years');
    }
};

