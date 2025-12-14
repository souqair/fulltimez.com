<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            JobCategorySeeder::class,
            EmploymentTypeSeeder::class,
            ExperienceLevelSeeder::class,
            ExperienceYearSeeder::class,
            EducationLevelSeeder::class,
            SalaryCurrencySeeder::class,
            SalaryPeriodSeeder::class,
            UserSeeder::class,
            JobPostingSeeder::class,
        ]);
    }
}
