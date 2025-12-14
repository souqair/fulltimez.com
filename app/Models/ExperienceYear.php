<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExperienceYear extends Model
{
    protected $fillable = ['name', 'value', 'sort_order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function jobPostings(): HasMany
    {
        return $this->hasMany(JobPosting::class, 'experience_year_id');
    }
}

