<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPosting extends Model
{
    protected $fillable = [
        'employer_id',
        'category_id',
        'title',
        'slug',
        'description',
        'requirements',
        'responsibilities',
        'benefits',
        'employment_type_id',
        'experience_level_id',
        'experience_year_id',
        'education_level_id',
        'salary_min',
        'salary_max',
        'salary_currency_id',
        'salary_period_id',
        'salary_type',
        'salary_negotiable',
        'gender',
        'age_from',
        'age_to',
        'age_below',
        'location_city',
        'location_state',
        'location_country',
        'is_oep_pakistan',
        'oep_permission_number',
        'remote_allowed',
        'positions_available',
        'application_deadline',
        'skills_required',
        'languages_required',
        'status',
        'priority',
        'ad_type',
        'is_premium',
        'premium_expires_at',
        'views_count',
        'applications_count',
        'published_at',
        'featured_expires_at',
        'featured_duration',
        'featured_amount',
    ];

    protected $casts = [
        'application_deadline' => 'date',
        'skills_required' => 'json',
        'languages_required' => 'json',
        'salary_negotiable' => 'boolean',
        'remote_allowed' => 'boolean',
        'is_oep_pakistan' => 'boolean',
        'age_from' => 'integer',
        'age_to' => 'integer',
        'age_below' => 'integer',
        'is_premium' => 'boolean',
        'premium_expires_at' => 'datetime',
        'published_at' => 'datetime',
        'featured_expires_at' => 'datetime',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    public function employmentType(): BelongsTo
    {
        return $this->belongsTo(EmploymentType::class, 'employment_type_id');
    }

    public function experienceLevel(): BelongsTo
    {
        return $this->belongsTo(ExperienceLevel::class, 'experience_level_id');
    }

    public function experienceYear(): BelongsTo
    {
        return $this->belongsTo(ExperienceYear::class, 'experience_year_id');
    }

    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class, 'education_level_id');
    }

    public function salaryCurrency(): BelongsTo
    {
        return $this->belongsTo(SalaryCurrency::class, 'salary_currency_id');
    }

    public function salaryPeriod(): BelongsTo
    {
        return $this->belongsTo(SalaryPeriod::class, 'salary_period_id');
    }

    /**
     * Check if the job is currently featured
     */
    public function isFeatured(): bool
    {
        if (!$this->featured_expires_at || !$this->featured_expires_at->isFuture()) {
            return false;
        }

        return $this->ad_type === 'featured'
            || in_array($this->priority, ['featured', 'premium', 'premium_15', 'premium_30'], true)
            || (bool) $this->is_premium;
    }

    /**
     * Scope for featured jobs
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured_expires_at', '>', now())
            ->where(function($q) {
                $q->where('ad_type', 'featured')
                  ->orWhereIn('priority', ['featured', 'premium', 'premium_15', 'premium_30'])
                  ->orWhere('is_premium', true);
            });
    }

    /**
     * Scope for non-featured jobs
     */
    public function scopeNotFeatured($query)
    {
        return $query->where(function($q) {
            $q->whereNull('featured_expires_at')
              ->orWhere('featured_expires_at', '<=', now())
              ->orWhere(function($sub) {
                  $sub->whereIn('ad_type', [null, 'recommended'])
                      ->whereIn('priority', [null, 'normal']);
              });
        });
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }

    public function isPremiumActive(): bool
    {
        return $this->is_premium && 
               $this->premium_expires_at && 
               $this->premium_expires_at->isFuture();
    }

    public function getPremiumStatusAttribute(): string
    {
        if (!$this->is_premium) {
            return 'standard';
        }

        if (!$this->premium_expires_at) {
            return 'premium';
        }

        if ($this->premium_expires_at->isFuture()) {
            return 'premium_active';
        }

        return 'premium_expired';
    }
}

