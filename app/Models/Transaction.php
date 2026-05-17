<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'source_type',
        'source_id',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'stripe_invoice_id',
        'base_amount_usd',
        'vat_amount_usd',
        'total_amount_usd',
        'currency',
        'country_key',
        'status',
        'failure_reason',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'base_amount_usd' => 'decimal:2',
        'vat_amount_usd' => 'decimal:2',
        'total_amount_usd' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function source(): MorphTo
    {
        return $this->morphTo();
    }
}
