<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'stripe_customer_id',
        'stripe_subscription_id',
        'status',
        'billing_cycle',
        'country_key',
        'vat_rate',
        'base_amount_usd',
        'vat_amount_usd',
        'total_amount_usd',
        'current_period_start',
        'current_period_end',
        'canceled_at',
        'ends_at',
    ];

    protected $casts = [
        'current_period_start' => 'datetime',
        'current_period_end' => 'datetime',
        'canceled_at' => 'datetime',
        'ends_at' => 'datetime',
        'vat_rate' => 'decimal:3',
        'base_amount_usd' => 'decimal:2',
        'vat_amount_usd' => 'decimal:2',
        'total_amount_usd' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function isActive(): bool
    {
        return in_array($this->status, ['active', 'past_due'], true)
            && (! $this->ends_at || $this->ends_at->isFuture());
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['active', 'past_due']);
    }
}
