<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VatRate extends Model
{
    protected $fillable = [
        'country_key',
        'country_name',
        'label',
        'rate',
        'stripe_tax_rate_id',
        'is_active',
    ];

    protected $casts = [
        'rate' => 'decimal:3',
        'is_active' => 'boolean',
    ];

    public static function forCountry(?string $countryKey): self
    {
        $key = $countryKey ?: 'global';
        return static::where('country_key', $key)
            ->where('is_active', true)
            ->firstOr(fn () => static::firstOrCreate(
                ['country_key' => 'global'],
                ['country_name' => 'Global', 'label' => 'VAT', 'rate' => 0, 'is_active' => true]
            ));
    }

    public function calculate(float $base): array
    {
        $rate = (float) $this->rate;
        $vat = round($base * $rate / 100, 2);
        return [
            'base'  => round($base, 2),
            'vat'   => $vat,
            'total' => round($base + $vat, 2),
            'rate'  => $rate,
            'label' => $this->label,
        ];
    }
}
