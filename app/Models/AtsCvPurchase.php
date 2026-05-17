<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AtsCvPurchase extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'stripe_payment_intent_id',
        'stripe_checkout_session_id',
        'source_cv_path',
        'generated_cv_path',
        'parsed_data',
        'rewrite_payload',
        'ats_score',
        'status',
        'country_key',
        'vat_rate',
        'base_amount_usd',
        'vat_amount_usd',
        'total_amount_usd',
        'error_message',
        'paid_at',
        'completed_at',
    ];

    protected $casts = [
        'parsed_data' => 'array',
        'rewrite_payload' => 'array',
        'paid_at' => 'datetime',
        'completed_at' => 'datetime',
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
}
