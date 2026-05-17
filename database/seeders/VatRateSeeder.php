<?php

namespace Database\Seeders;

use App\Models\VatRate;
use Illuminate\Database\Seeder;

class VatRateSeeder extends Seeder
{
    public function run(): void
    {
        $rates = [
            ['country_key' => 'global', 'country_name' => 'Global',                'label' => 'VAT', 'rate' => 0.000,  'is_active' => true],
            ['country_key' => 'pk',     'country_name' => 'Pakistan',              'label' => 'GST', 'rate' => 18.000, 'is_active' => true],
            ['country_key' => 'ae',     'country_name' => 'United Arab Emirates',  'label' => 'VAT', 'rate' => 5.000,  'is_active' => true],
            ['country_key' => 'sa',     'country_name' => 'Saudi Arabia',          'label' => 'VAT', 'rate' => 15.000, 'is_active' => true],
        ];

        foreach ($rates as $rate) {
            VatRate::updateOrCreate(['country_key' => $rate['country_key']], $rate);
        }
    }
}
