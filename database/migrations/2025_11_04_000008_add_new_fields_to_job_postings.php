<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_postings', function (Blueprint $table) {
            // Add salary_type field (keep salary_negotiable for backward compatibility)
            $table->enum('salary_type', ['fixed', 'negotiable', 'based_on_experience', 'salary_plus_commission'])->nullable()->after('salary_period_id');
            
            // Add gender field
            $table->enum('gender', ['male', 'female', 'any'])->default('any')->after('education_level_id');
            
            // Add age fields
            $table->integer('age_from')->nullable()->after('gender');
            $table->integer('age_to')->nullable()->after('age_from');
            $table->integer('age_below')->nullable()->after('age_to');
        });
        
        // Migrate existing salary_negotiable to salary_type
        DB::table('job_postings')
            ->where('salary_negotiable', true)
            ->update(['salary_type' => 'negotiable']);
        
        DB::table('job_postings')
            ->whereNull('salary_type')
            ->update(['salary_type' => 'fixed']);
    }

    public function down(): void
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropColumn(['salary_type', 'gender', 'age_from', 'age_to', 'age_below']);
        });
    }
};

