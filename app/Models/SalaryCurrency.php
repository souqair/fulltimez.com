<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalaryCurrency extends Model
{
    protected $fillable = ['code', 'name', 'symbol', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function jobPostings(): HasMany
    {
        return $this->hasMany(JobPosting::class, 'salary_currency_id');
    }
}

