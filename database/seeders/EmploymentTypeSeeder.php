<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EmploymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Full-time',
                'slug' => 'full-time',
                'description' => 'Full-time employment with regular working hours',
                'is_active' => true,
            ],
            [
                'name' => 'Part-time',
                'slug' => 'part-time',
                'description' => 'Part-time employment with reduced working hours',
                'is_active' => true,
            ],
            [
                'name' => 'Contract',
                'slug' => 'contract',
                'description' => 'Contract-based employment for a specific duration',
                'is_active' => true,
            ],
            [
                'name' => 'Freelance',
                'slug' => 'freelance',
                'description' => 'Freelance or project-based work',
                'is_active' => true,
            ],
            [
                'name' => 'Internship',
                'slug' => 'internship',
                'description' => 'Internship position for students or recent graduates',
                'is_active' => true,
            ],
        ];

        foreach ($types as $type) {
            DB::table('employment_types')->updateOrInsert(
                ['slug' => $type['slug']],
                $type
            );
        }
    }
}

