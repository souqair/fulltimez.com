<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EducationLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['name' => 'PhD', 'slug' => 'phd', 'description' => 'Doctorate degree', 'is_active' => true],
            ['name' => 'Master', 'slug' => 'master', 'description' => 'Master degree', 'is_active' => true],
            ['name' => 'Bachelor', 'slug' => 'bachelor', 'description' => 'Bachelor degree', 'is_active' => true],
            ['name' => 'Intermediate', 'slug' => 'intermediate', 'description' => 'Intermediate education', 'is_active' => true],
            ['name' => 'Higher Secondary', 'slug' => 'higher-secondary', 'description' => 'Higher secondary education', 'is_active' => true],
            ['name' => 'Diploma', 'slug' => 'diploma', 'description' => 'Diploma certificate', 'is_active' => true],
            ['name' => 'Primary', 'slug' => 'primary', 'description' => 'Primary education', 'is_active' => true],
            ['name' => 'Not Required', 'slug' => 'not-required', 'description' => 'No education requirement', 'is_active' => true],
        ];

        foreach ($levels as $level) {
            DB::table('education_levels')->updateOrInsert(
                ['slug' => $level['slug']],
                $level
            );
        }
    }
}

