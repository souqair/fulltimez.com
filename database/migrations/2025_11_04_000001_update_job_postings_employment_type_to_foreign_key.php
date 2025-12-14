<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, add the new column
        Schema::table('job_postings', function (Blueprint $table) {
            $table->foreignId('employment_type_id')->nullable()->after('benefits')->constrained('employment_types')->onDelete('set null');
        });

        // Migrate existing data - ensure employment types exist first
        $employmentTypes = [
            'full-time' => 'Full-time',
            'part-time' => 'Part-time',
            'contract' => 'Contract',
            'freelance' => 'Freelance',
            'internship' => 'Internship',
        ];

        foreach ($employmentTypes as $slug => $name) {
            $type = DB::table('employment_types')->where('slug', $slug)->first();
            if (!$type) {
                // Create if doesn't exist (in case seeder hasn't run)
                $typeId = DB::table('employment_types')->insertGetId([
                    'name' => $name,
                    'slug' => $slug,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $type = (object)['id' => $typeId];
            }
            
            if ($type) {
                DB::table('job_postings')
                    ->where('employment_type', $slug)
                    ->update(['employment_type_id' => $type->id]);
            }
        }

        // Drop the old enum column
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropColumn('employment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the enum column
        Schema::table('job_postings', function (Blueprint $table) {
            $table->enum('employment_type', ['full-time', 'part-time', 'contract', 'freelance', 'internship'])->default('full-time')->after('benefits');
        });

        // Migrate data back
        $types = DB::table('employment_types')->get();
        foreach ($types as $type) {
            DB::table('job_postings')
                ->where('employment_type_id', $type->id)
                ->update(['employment_type' => $type->slug]);
        }

        // Drop the foreign key column
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropForeign(['employment_type_id']);
            $table->dropColumn('employment_type_id');
        });
    }
};

