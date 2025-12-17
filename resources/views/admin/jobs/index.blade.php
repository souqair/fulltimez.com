@extends('layouts.admin')

@section('title', 'Jobs Management')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Jobs Management</h4>
            <p class="text-muted mb-0">Manage all job postings</p>
        </div>
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Job
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-primary">
                <div class="stat-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $stats['total'] }}</h3>
                    <p class="stat-label">Total Jobs</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-success">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $stats['published'] }}</h3>
                    <p class="stat-label">Published</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-warning">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $stats['pending'] + $stats['featured_pending'] }}</h3>
                    <p class="stat-label">Pending</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-info">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $stats['featured_pending'] }}</h3>
                    <p class="stat-label">Featured Pending</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="admin-card mb-4">
        <div class="admin-card-body">
            <form method="GET" action="{{ route('admin.jobs.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" class="form-control" name="search" placeholder="Search jobs..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Company</label>
                    <select class="form-control" name="company">
                        <option value="">All Companies</option>
                        @foreach($jobs->pluck('employer.employerProfile.company_name')->unique()->filter() as $company)
                            <option value="{{ $company }}" {{ request('company') == $company ? 'selected' : '' }}>
                                {{ $company }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select class="form-control" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="featured_pending" {{ request('status') == 'featured_pending' ? 'selected' : '' }}>Featured Pending</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">OEP Status</label>
                    <select class="form-control" name="is_oep_pakistan">
                        <option value="">All</option>
                        <option value="1" {{ request('is_oep_pakistan') == '1' ? 'selected' : '' }}>OEP (Yes)</option>
                        <option value="0" {{ request('is_oep_pakistan') == '0' ? 'selected' : '' }}>Not OEP</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Jobs Grid -->
    <div class="row g-4">
        @forelse($jobs as $job)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="job-card-modern">
                    <div class="job-card-top">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="job-title-modern">
                                    <a href="{{ route('admin.jobs.show', $job) }}">
                                        {{ $job->title }}
                                    </a>
                                </h5>
                                @if($job->employer && $job->employer->employerProfile)
                                    <p class="job-company-modern">
                                        <i class="fas fa-building"></i>
                                        {{ $job->employer->employerProfile->company_name }}
                                    </p>
                                @endif
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" type="button" id="jobActions{{ $job->id }}" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="jobActions{{ $job->id }}">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.jobs.show', $job) }}">
                                            <i class="fas fa-eye text-primary"></i> View Details
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.jobs.edit', $job) }}">
                                            <i class="fas fa-edit text-info"></i> Edit Job
                                        </a>
                                    </li>
                                    @if($job->status === 'pending' || $job->status === 'featured_pending')
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.jobs.approve', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Approve this job?');">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-success">
                                                    <i class="fas fa-check"></i> Approve Job
                                                </button>
                                            </form>
                                        </li>
                                        @if($job->status === 'featured_pending')
                                        <li>
                                            <form action="{{ route('admin.jobs.approve', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Approve as Recommended?');">
                                                @csrf
                                                <input type="hidden" name="as_recommended" value="1">
                                                <button type="submit" class="dropdown-item text-info">
                                                    <i class="fas fa-thumbs-up"></i> Approve as Recommended
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        <li>
                                            <form action="{{ route('admin.jobs.reject', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Reject this job?');">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-times"></i> Reject Job
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                    @if($job->status === 'published')
                                        <li><hr class="dropdown-divider"></li>
                                        @if($job->ad_type === 'featured' || $job->isFeatured())
                                        <li>
                                            <form action="{{ route('admin.jobs.toggle-featured', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Convert to Regular?');">
                                                @csrf
                                                <input type="hidden" name="make_featured" value="0">
                                                <button type="submit" class="dropdown-item text-warning">
                                                    <i class="fas fa-star-half-alt"></i> Convert to Regular
                                                </button>
                                            </form>
                                        </li>
                                        @else
                                        <li>
                                            <button type="button" class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#featureJobModal{{ $job->id }}">
                                                <i class="fas fa-star"></i> Make Featured
                                            </button>
                                        </li>
                                        @endif
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this job?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash"></i> Delete Job
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="job-badges-modern mt-3">
                            @if($job->status == 'published')
                                <span class="badge badge-success">Published</span>
                            @elseif($job->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($job->status == 'featured_pending')
                                <span class="badge badge-info">Featured Pending</span>
                            @elseif($job->status == 'draft')
                                <span class="badge badge-secondary">Draft</span>
                            @else
                                <span class="badge badge-danger">Closed</span>
                            @endif
                            @if($job->ad_type === 'featured' || $job->isFeatured())
                                <span class="badge badge-warning">
                                    <i class="fas fa-star"></i> Featured
                                </span>
                            @endif
                            @if($job->category)
                                <span class="badge badge-primary">{{ $job->category->name }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="job-card-body-modern">
                        <div class="job-info-row">
                            <div class="job-info-item-modern">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $job->location_city }}, {{ $job->location_country }}</span>
                            </div>
                        </div>
                        
                        @if($job->is_oep_pakistan == 1 && $job->oep_permission_number)
                            <div class="job-info-row">
                                <div class="job-info-item-modern job-info-oep-modern">
                                    <i class="fas fa-certificate"></i>
                                    <span><strong>OEP Permission#:</strong> {{ $job->oep_permission_number }}</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($job->salary_min || $job->salary_max)
                            <div class="job-info-row">
                                <div class="job-info-item-modern">
                                    <i class="fas fa-dollar-sign"></i>
                                    <span>
                                        @if($job->salary_min && $job->salary_max)
                                            ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                                        @elseif($job->salary_min)
                                            From ${{ number_format($job->salary_min) }}
                                        @else
                                            Up to ${{ number_format($job->salary_max) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endif
                        
                        <div class="job-info-row">
                            <div class="job-info-item-modern">
                                <i class="fas fa-users"></i>
                                <span>{{ $job->applications()->count() }} Application(s)</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="job-card-footer-modern">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-calendar"></i>
                                {{ $job->created_at->format('M j, Y') }}
                            </small>
                            <div class="job-actions-modern">
                                <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="admin-card">
                    <div class="admin-card-body text-center py-5">
                        <i class="fas fa-briefcase fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No jobs found</h5>
                        <p class="text-muted">No jobs match your current filters.</p>
                        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus"></i> Create First Job
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-md-6">
            <p class="text-muted mb-0">
                Showing {{ $jobs->firstItem() ?? 0 }} to {{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} jobs
            </p>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-end align-items-center gap-3">
                <form method="GET" action="{{ route('admin.jobs.index') }}">
                    @foreach(request()->query() as $key => $value)
                        @if($key !== 'per_page')
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <select name="per_page" class="form-control form-control-sm d-inline-block" style="width: auto;" onchange="this.form.submit()">
                        <option value="12" {{ request('per_page', 20) == 12 ? 'selected' : '' }}>12 per page</option>
                        <option value="24" {{ request('per_page', 20) == 24 ? 'selected' : '' }}>24 per page</option>
                        <option value="48" {{ request('per_page', 20) == 48 ? 'selected' : '' }}>48 per page</option>
                        <option value="96" {{ request('per_page', 20) == 96 ? 'selected' : '' }}>96 per page</option>
                    </select>
                </form>
                <div>
                    {{ $jobs->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Feature Job Modals -->
@foreach($jobs as $job)
    @if($job->status === 'published' && ($job->ad_type !== 'featured' && !$job->isFeatured()))
    <div class="modal fade" id="featureJobModal{{ $job->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Feature Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.jobs.toggle-featured', $job) }}" method="POST">
                    @csrf
                    <input type="hidden" name="make_featured" value="1">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="featured_duration{{ $job->id }}" class="form-label">Featured Duration (Days)</label>
                            <input type="number" class="form-control" id="featured_duration{{ $job->id }}" name="featured_duration" min="1" max="365" value="7" required>
                            <small class="form-text text-muted">Job will be featured on homepage for the specified number of days.</small>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> This job will appear in the featured section on homepage.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-star"></i> Feature Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach

@push('styles')
<style>
/* Statistics Cards */
.stat-card {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
    height: 100%;
}

.stat-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    transform: translateY(-2px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #fff;
    flex-shrink: 0;
}

.stat-primary .stat-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.stat-success .stat-icon { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
.stat-warning .stat-icon { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
.stat-info .stat-icon { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }

.stat-number {
    font-size: 32px;
    font-weight: 700;
    margin: 0;
    color: #1f2937;
    line-height: 1;
}

.stat-label {
    font-size: 14px;
    color: #6b7280;
    margin: 8px 0 0 0;
    font-weight: 500;
}

/* Modern Job Cards */
.job-card-modern {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.job-card-modern:hover {
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
    transform: translateY(-4px);
    border-color: #d1d5db;
}

.job-card-top {
    padding: 20px;
    border-bottom: 1px solid #f3f4f6;
}

.job-title-modern {
    font-size: 18px;
    font-weight: 600;
    margin: 0 0 8px 0;
    line-height: 1.4;
}

.job-title-modern a {
    color: #1f2937;
    text-decoration: none;
    transition: color 0.2s;
}

.job-title-modern a:hover {
    color: #667eea;
}

.job-company-modern {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 6px;
}

.job-company-modern i {
    font-size: 12px;
    color: #9ca3af;
}

.job-badges-modern {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.job-badges-modern .badge {
    font-size: 11px;
    font-weight: 600;
    padding: 6px 10px;
    border-radius: 6px;
}

.job-card-body-modern {
    padding: 20px;
    flex: 1;
}

.job-info-row {
    margin-bottom: 12px;
}

.job-info-row:last-child {
    margin-bottom: 0;
}

.job-info-item-modern {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    color: #4b5563;
}

.job-info-item-modern i {
    font-size: 14px;
    color: #9ca3af;
    width: 18px;
    text-align: center;
}

.job-info-oep-modern {
    color: #0284c7;
    font-weight: 500;
}

.job-info-oep-modern i {
    color: #0284c7;
}

.job-card-footer-modern {
    padding: 16px 20px;
    background: #f9fafb;
    border-top: 1px solid #f3f4f6;
}

.job-actions-modern {
    display: flex;
    gap: 8px;
}

.job-actions-modern .btn {
    font-size: 13px;
    padding: 6px 12px;
}

/* Admin Card */
.admin-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
    overflow: hidden;
}

.admin-card-body {
    padding: 24px;
}

/* Responsive */
@media (max-width: 1200px) {
    .job-card-modern {
        margin-bottom: 0;
    }
}

@media (max-width: 768px) {
    .job-card-modern {
        margin-bottom: 1rem;
    }
    
    .job-actions-modern {
        flex-direction: column;
        width: 100%;
    }
    
    .job-actions-modern .btn {
        width: 100%;
    }
}
</style>
@endpush
@endsection
