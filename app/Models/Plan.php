<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'features',
        'type',
        'price_monthly_usd',
        'price_yearly_usd',
        'price_onetime_usd',
        'stripe_product_id',
        'stripe_price_id_monthly',
        'stripe_price_id_yearly',
        'stripe_price_id_onetime',
        'is_active',
        'is_featured',
        'sort_order',
        'cta_label',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price_monthly_usd' => 'decimal:2',
        'price_yearly_usd' => 'decimal:2',
        'price_onetime_usd' => 'decimal:2',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSubscription($query)
    {
        return $query->where('type', 'subscription');
    }

    public function scopeOneTime($query)
    {
        return $query->where('type', 'one_time');
    }

    public function priceFor(string $billingCycle): ?float
    {
        return match ($billingCycle) {
            'monthly'  => $this->price_monthly_usd ? (float) $this->price_monthly_usd : null,
            'yearly'   => $this->price_yearly_usd ? (float) $this->price_yearly_usd : null,
            'onetime'  => $this->price_onetime_usd ? (float) $this->price_onetime_usd : null,
            default    => null,
        };
    }

    public function stripePriceIdFor(string $billingCycle): ?string
    {
        return match ($billingCycle) {
            'monthly'  => $this->stripe_price_id_monthly,
            'yearly'   => $this->stripe_price_id_yearly,
            'onetime'  => $this->stripe_price_id_onetime,
            default    => null,
        };
    }
}
