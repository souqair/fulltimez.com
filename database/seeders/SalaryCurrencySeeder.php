<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaryCurrencySeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            ['code' => 'AED', 'name' => 'UAE Dirham', 'symbol' => 'د.إ', 'is_active' => true],
            ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$', 'is_active' => true],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'is_active' => true],
            ['code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£', 'is_active' => true],
            ['code' => 'SAR', 'name' => 'Saudi Riyal', 'symbol' => '﷼', 'is_active' => true],
            ['code' => 'INR', 'name' => 'Indian Rupee', 'symbol' => '₹', 'is_active' => true],
            ['code' => 'PKR', 'name' => 'Pakistani Rupee', 'symbol' => '₨', 'is_active' => true],
        ];

        foreach ($currencies as $currency) {
            DB::table('salary_currencies')->updateOrInsert(
                ['code' => $currency['code']],
                $currency
            );
        }
    }
}

