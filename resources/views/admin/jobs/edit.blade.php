@extends('layouts.admin')

@section('title', 'Edit Job')
@section('page-title', 'Edit Job')

@push('styles')
<style>
/* Hide search section on employer jobs edit page */
.search-wrap {
    display: none !important;
}

/* Modern Job Edit Form Styles */
.professional-form-container {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid #e8e8e8;
    overflow: hidden;
    position: relative;
}

.professional-form-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #1a1a1a, #28a745, #ffc107, #dc3545);
}

.form-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #e8e8e8;
    padding: 2.5rem;
    position: relative;
}

.form-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="%23e9ecef" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.form-header-content {
    position: relative;
    z-index: 1;
}

.form-header h2 {
    color: #2c3e50;
    font-weight: 700;
    margin: 0;
    font-size: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.form-header h2::before {
    content: '✏️';
    font-size: 1.5rem;
}

.form-header p {
    color: #6c757d;
    margin: 0.75rem 0 0 0;
    font-size: 1rem;
    font-weight: 500;
}

.form-body {
    padding: 2.5rem;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
}

.form-section {
    margin-bottom: 3rem;
    padding: 2rem;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
    border: 1px solid #f0f0f0;
    position: relative;
    transition: all 0.3s ease;
}

.form-section:hover {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

.form-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, #1a1a1a, #28a745);
    border-radius: 0 2px 2px 0;
}

.auto-deadline-info {
    background: rgba(0, 123, 255, 0.08);
    border: 1px dashed rgba(0, 123, 255, 0.3);
    border-radius: 12px;
    padding: 1.25rem;
    color: #0c3c78;
    font-weight: 500;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.auto-deadline-info i {
    font-size: 1.4rem;
    color: #1a1a1a;
    margin-top: 0.15rem;
}

.section-title {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 2rem;
    padding-left: 1rem;
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title::before {
    content: '';
    width: 4px;
    height: 30px;
    background: linear-gradient(180deg, #1a1a1a, #28a745);
    border-radius: 2px;
    position: absolute;
    left: -1rem;
}

.form-group {
    margin-bottom: 2rem;
    position: relative;
}

.form-label {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-label::before {
    content: '';
    width: 3px;
    height: 16px;
    background: linear-gradient(180deg, #1a1a1a, #28a745);
    border-radius: 2px;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 1rem 1.25rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
}

.form-control:focus {
    border-color: #1a1a1a;
    box-shadow: 0 0 0 0.3rem rgba(0, 123, 255, 0.1), 0 4px 12px rgba(0, 123, 255, 0.15);
    outline: none;
    transform: translateY(-1px);
}

.form-control:hover {
    border-color: #1a1a1a;
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.3rem rgba(220, 53, 69, 0.1);
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.85rem;
    margin-top: 0.5rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.invalid-feedback::before {
    content: '⚠️';
    font-size: 0.8rem;
}

/* Action Buttons */
.form-actions {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-top: 1px solid #e8e8e8;
    padding: 2rem 2.5rem;
    position: relative;
}

.form-actions::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, #1a1a1a, transparent);
}

.btn {
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.btn:hover::before {
    left: 100%;
}

.btn-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #5a6268 0%, #495057 100%);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
}

.btn-primary {
    background: linear-gradient(135deg, #1a1a1a 0%, #1a1a1a 100%);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #1a1a1a 0%, #004085 100%);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-header {
        padding: 2rem;
    }
    
    .form-body {
        padding: 1.5rem;
    }
    
    .form-section {
        padding: 1.5rem;
    }
    
    .form-actions {
        padding: 1.5rem;
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
                <div class="professional-form-container">
                    <!-- Header Section -->
                    <div class="form-header">
                        <div class="form-header-content">
                            <h2>Edit Job Posting</h2>
                            <p>Update your job posting details below. All fields marked with * are required.</p>
                        </div>
                    </div>

                    <div class="form-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.jobs.update', $job) }}" method="POST" id="jobEditForm">
                            @csrf
                            @method('PUT')
                            @php
                            @endphp
                            
                            <!-- Basic Information Section -->
                            <div class="form-section">
                                <h3 class="section-title">
                                    <i class="fas fa-info-circle text-primary"></i>
                                    Basic Information
                                </h3>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Employer <sup class="text-danger">*</sup></label>
                                            <select name="employer_id" class="form-control @error('employer_id') is-invalid @enderror" required>
                                                <option value="">Select Employer</option>
                                                @foreach($employers as $employer)
                                                    <option value="{{ $employer->id }}" {{ old('employer_id', $job->employer_id) == $employer->id ? 'selected' : '' }}>
                                                        {{ $employer->employerProfile->company_name ?? $employer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('employer_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Job Title <sup class="text-danger">*</sup></label>
                                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $job->title) }}" placeholder="e.g., Software Engineer" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Category <sup class="text-danger">*</sup></label>
                                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Employment Type <sup class="text-danger">*</sup></label>
                                            <select name="employment_type_id" class="form-control @error('employment_type_id') is-invalid @enderror" required>
                                                <option value="">Select Type</option>
                                                @foreach($employmentTypes as $type)
                                                    <option value="{{ $type->id }}" {{ old('employment_type_id', $job->employment_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('employment_type_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Hidden Priority Field -->
                                    <input type="hidden" name="priority" value="{{ old('priority', $job->priority ?? 'normal') }}">
                                </div>
                            </div>

                            <!-- Job Details Section -->
                            <div class="form-section">
                                <h3 class="section-title">
                                    <i class="fas fa-briefcase text-success"></i>
                                    Job Details
                                </h3>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Job Description <sup class="text-danger">*</sup></label>
                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Describe the job in detail..." required>{{ old('description', $job->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Requirements</label>
                                            <textarea name="requirements" class="form-control @error('requirements') is-invalid @enderror" rows="4" placeholder="List the job requirements...">{{ old('requirements', $job->requirements) }}</textarea>
                                            @error('requirements')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Responsibilities</label>
                                            <textarea name="responsibilities" class="form-control @error('responsibilities') is-invalid @enderror" rows="4" placeholder="List the job responsibilities...">{{ old('responsibilities', $job->responsibilities) }}</textarea>
                                            @error('responsibilities')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Location & Requirements Section -->
                            <div class="form-section">
                                <h3 class="section-title">
                                    <i class="fas fa-map-marker-alt text-warning"></i>
                                    Location & Requirements
                                </h3>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Location (City) <sup class="text-danger">*</sup></label>
                                            <select name="location_city" id="location_city" class="form-control @error('location_city') is-invalid @enderror" required>
                                                <option value="">Select City</option>
                                            </select>
                                            @error('location_city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Location (Country) <sup class="text-danger">*</sup></label>
                                            <select name="location_country" id="location_country" class="form-control @error('location_country') is-invalid @enderror" required>
                                                <option value="">Select Country</option>
                                                @php $oldCountry = old('location_country', $job->location_country); @endphp
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->name }}" {{ $oldCountry == $country->name ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('location_country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Experience Level <sup class="text-danger">*</sup></label>
                                            <select name="experience_level_id" class="form-control @error('experience_level_id') is-invalid @enderror" required>
                                                <option value="">Select Experience Level</option>
                                                @foreach($experienceLevels as $level)
                                                    <option value="{{ $level->id }}" {{ old('experience_level_id', $job->experience_level_id) == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('experience_level_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Experience Years <sup class="text-danger">*</sup></label>
                                            <select name="experience_year_id" class="form-control @error('experience_year_id') is-invalid @enderror" required>
                                                <option value="">Select Experience Years</option>
                                                @foreach($experienceYears as $year)
                                                    <option value="{{ $year->id }}" {{ old('experience_year_id', $job->experience_year_id) == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('experience_year_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Education Level <sup class="text-danger">*</sup></label>
                                            <select name="education_level_id" class="form-control @error('education_level_id') is-invalid @enderror" required>
                                                <option value="">Select Education</option>
                                                @foreach($educationLevels as $level)
                                                    <option value="{{ $level->id }}" {{ old('education_level_id', $job->education_level_id) == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('education_level_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Gender <sup class="text-danger">*</sup></label>
                                            <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                                                <option value="">Select Gender</option>
                                                <option value="any" {{ old('gender', $job->gender ?? 'any') == 'any' ? 'selected' : '' }}>Any</option>
                                                <option value="male" {{ old('gender', $job->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender', $job->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Age From</label>
                                            <input type="number" name="age_from" class="form-control @error('age_from') is-invalid @enderror" value="{{ old('age_from', $job->age_from) }}" placeholder="e.g., 25" min="18" max="100">
                                            @error('age_from')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Age To</label>
                                            <input type="number" name="age_to" class="form-control @error('age_to') is-invalid @enderror" value="{{ old('age_to', $job->age_to) }}" placeholder="e.g., 45" min="18" max="100">
                                            @error('age_to')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Age Below</label>
                                            <input type="number" name="age_below" class="form-control @error('age_below') is-invalid @enderror" value="{{ old('age_below', $job->age_below) }}" placeholder="e.g., 60" min="18" max="100">
                                            <small class="form-text text-muted">Use this OR age range above</small>
                                            @error('age_below')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Salary & Status Section -->
                            <div class="form-section">
                                <h3 class="section-title">
                                    <i class="fas fa-dollar-sign text-info"></i>
                                    Salary & Status
                                </h3>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Minimum Salary</label>
                                            <input type="number" name="salary_min" class="form-control @error('salary_min') is-invalid @enderror" value="{{ old('salary_min', $job->salary_min) }}" placeholder="e.g., 5000">
                                            @error('salary_min')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Maximum Salary</label>
                                            <input type="number" name="salary_max" class="form-control @error('salary_max') is-invalid @enderror" value="{{ old('salary_max', $job->salary_max) }}" placeholder="e.g., 8000">
                                            @error('salary_max')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Salary Currency</label>
                                            <select name="salary_currency_id" class="form-control @error('salary_currency_id') is-invalid @enderror">
                                                <option value="">Select Currency</option>
                                                @foreach($salaryCurrencies as $currency)
                                                    <option value="{{ $currency->id }}" {{ old('salary_currency_id', $job->salary_currency_id) == $currency->id ? 'selected' : '' }}>
                                                        {{ $currency->code }} - {{ $currency->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('salary_currency_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Salary Period</label>
                                            <select name="salary_period_id" class="form-control @error('salary_period_id') is-invalid @enderror">
                                                <option value="">Select Period</option>
                                                @foreach($salaryPeriods as $period)
                                                    <option value="{{ $period->id }}" {{ old('salary_period_id', $job->salary_period_id) == $period->id ? 'selected' : '' }}>
                                                        {{ $period->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('salary_period_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Salary Type <sup class="text-danger">*</sup></label>
                                            <select name="salary_type" class="form-control @error('salary_type') is-invalid @enderror" required>
                                                <option value="">Select Salary Type</option>
                                                <option value="fixed" {{ old('salary_type', $job->salary_type ?? 'fixed') == 'fixed' ? 'selected' : '' }}>Fixed Salary</option>
                                                <option value="negotiable" {{ old('salary_type', $job->salary_type) == 'negotiable' ? 'selected' : '' }}>Negotiable</option>
                                                <option value="based_on_experience" {{ old('salary_type', $job->salary_type) == 'based_on_experience' ? 'selected' : '' }}>Based on Experience</option>
                                                <option value="salary_plus_commission" {{ old('salary_type', $job->salary_type) == 'salary_plus_commission' ? 'selected' : '' }}>Salary plus Commission</option>
                                            </select>
                                            @error('salary_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Application Deadline</label>
                                            <input type="date" name="application_deadline" class="form-control @error('application_deadline') is-invalid @enderror" value="{{ old('application_deadline', optional($job->application_deadline)->format('Y-m-d')) }}">
                                            @error('application_deadline')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Status <sup class="text-danger">*</sup></label>
                                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                                <option value="draft" {{ old('status', $job->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status', $job->status) == 'published' ? 'selected' : '' }}>Published</option>
                                                <option value="closed" {{ old('status', $job->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-arrow-left"></i> Back to Jobs
                            </a>
                            <button type="submit" form="jobEditForm" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Update Job
                            </button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Dynamic city loading based on country selection
document.addEventListener('DOMContentLoaded', function() {
    const countrySelect = document.getElementById('location_country');
    const citySelect = document.getElementById('location_city');

    function loadCities(countryName, selectedCity) {
        if (!citySelect) return;
        
        if (!countryName) {
            citySelect.innerHTML = '<option value="">Select City</option>';
            citySelect.disabled = false;
            return;
        }
        
        citySelect.innerHTML = '<option value="">Loading...</option>';
        citySelect.disabled = true;
        
        fetch(`{{ url('/api/cities') }}/${encodeURIComponent(countryName)}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                citySelect.innerHTML = '<option value="">Select City</option>';
                if (data.success && data.cities && Array.isArray(data.cities)) {
                    data.cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.name;
                        option.textContent = city.name;
                        if (selectedCity && selectedCity === city.name) {
                            option.selected = true;
                        }
                        citySelect.appendChild(option);
                    });
                }
                citySelect.disabled = false;
            })
            .catch(error => {
                console.error('Error loading cities:', error);
                citySelect.innerHTML = '<option value="">Select City</option>';
                citySelect.disabled = false;
            });
    }

    // Initialize on load with current values
    if (countrySelect && citySelect) {
        const initialCountry = countrySelect.value || '{{ $job->location_country }}';
        const initialCity = '{{ old('location_city', $job->location_city) }}';
        if (initialCountry) {
            loadCities(initialCountry, initialCity);
        }
        
        countrySelect.addEventListener('change', function(){
            loadCities(this.value, null);
        });
    }
});
</script>
@endpush
@endsection
