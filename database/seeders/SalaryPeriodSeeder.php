<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaryPeriodSeeder extends Seeder
{
    public function run(): void
    {
        $periods = [
            ['name' => 'Monthly', 'slug' => 'monthly', 'description' => 'Monthly salary', 'is_active' => true],
            ['name' => 'Yearly', 'slug' => 'yearly', 'description' => 'Annual salary', 'is_active' => true],
            ['name' => 'Weekly', 'slug' => 'weekly', 'description' => 'Weekly salary', 'is_active' => true],
            ['name' => 'Hourly', 'slug' => 'hourly', 'description' => 'Hourly wage', 'is_active' => true],
            ['name' => 'Daily', 'slug' => 'daily', 'description' => 'Daily wage', 'is_active' => true],
        ];

        foreach ($periods as $period) {
            DB::table('salary_periods')->updateOrInsert(
                ['slug' => $period['slug']],
                $period
            );
        }
    }
}

