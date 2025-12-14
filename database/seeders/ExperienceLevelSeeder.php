<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExperienceLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['name' => 'Entry Level', 'slug' => 'entry', 'description' => 'Entry level positions for beginners', 'is_active' => true],
            ['name' => 'Mid Level', 'slug' => 'mid', 'description' => 'Mid-level positions with some experience', 'is_active' => true],
            ['name' => 'Senior Level', 'slug' => 'senior', 'description' => 'Senior positions requiring extensive experience', 'is_active' => true],
            ['name' => 'Executive Level', 'slug' => 'executive', 'description' => 'Executive and leadership positions', 'is_active' => true],
        ];

        foreach ($levels as $level) {
            DB::table('experience_levels')->updateOrInsert(
                ['slug' => $level['slug']],
                $level
            );
        }
    }
}

