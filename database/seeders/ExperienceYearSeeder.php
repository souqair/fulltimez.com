<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExperienceYearSeeder extends Seeder
{
    public function run(): void
    {
        $years = [
            ['name' => 'Fresh', 'value' => 'Fresh', 'sort_order' => 0, 'is_active' => true],
        ];
        
        for ($i = 1; $i <= 10; $i++) {
            $name = $i === 1 ? '1 Year' : $i . ' Years';
            $years[] = [
                'name' => $name,
                'value' => $name,
                'sort_order' => $i,
                'is_active' => true,
            ];
        }

        foreach ($years as $year) {
            DB::table('experience_years')->updateOrInsert(
                ['value' => $year['value']],
                $year
            );
        }
    }
}

