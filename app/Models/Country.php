<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = ['name', 'code', 'is_active', 'approved_for_jobs'];

    protected $casts = [
        'is_active' => 'boolean',
        'approved_for_jobs' => 'boolean',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function jobPostings(): HasMany
    {
        return $this->hasMany(JobPosting::class, 'location_country');
    }
}
