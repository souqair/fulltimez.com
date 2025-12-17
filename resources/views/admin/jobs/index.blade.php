@extends('layouts.admin')

@section('title', 'Jobs Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Jobs Management</li>
                    </ol>
                </div>
                <h4 class="page-title">Jobs Management</h4>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-primary-subtle text-primary">
                                <i class="fas fa-briefcase font-20"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1">{{ $stats['total'] }}</h5>
                            <p class="text-muted mb-0">Total Jobs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-success-subtle text-success">
                                <i class="fas fa-check font-20"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1">{{ $stats['published'] }}</h5>
                            <p class="text-muted mb-0">Published</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-warning-subtle text-warning">
                                <i class="fas fa-clock font-20"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1">{{ $stats['pending'] }}</h5>
                            <p class="text-muted mb-0">Pending Approval</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-danger-subtle text-danger">
                                <i class="fas fa-times font-20"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1">{{ $stats['closed'] }}</h5>
                            <p class="text-muted mb-0">Closed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">All Jobs</h4>
                        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create Job
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filters -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('admin.jobs.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" 
                                           placeholder="Search jobs by title, location..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
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
                    <select class="form-control" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                        <option value="featured_pending" {{ request('status') == 'featured_pending' ? 'selected' : '' }}>Featured Ad Pending</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
        </div>
                <div class="col-md-2">
                    <select class="form-control" name="is_oep_pakistan">
                        <option value="">All OEP Status</option>
                        <option value="1" {{ request('is_oep_pakistan') == '1' ? 'selected' : '' }}>OEP in Pakistan (Yes)</option>
                        <option value="0" {{ request('is_oep_pakistan') == '0' ? 'selected' : '' }}>Not OEP (No)</option>
                    </select>
        </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                                </div>
                            </form>
                                </div>
                            </div>
                            
                    <!-- Jobs Grid -->
                    <div class="row g-3">
                        @forelse($jobs as $job)
                            <div class="col-6 col-md-4 col-lg-3 col-xl-2-4">
                                <div class="job-card-compact">
                                    <div class="job-card-header">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="flex-grow-1">
                                                <h6 class="job-title mb-1">
                                                    <a href="{{ route('admin.jobs.show', $job) }}" title="{{ $job->title }}">
                                                        {{ Str::limit($job->title, 40) }}
                                                    </a>
                                                </h6>
                                                @if($job->employer && $job->employer->employerProfile)
                                                    <p class="job-company mb-0">
                                                        <i class="fas fa-building"></i>
                                                        <span>{{ Str::limit($job->employer->employerProfile->company_name, 25) }}</span>
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn-icon" type="button" id="jobActions{{ $job->id }}" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="jobActions{{ $job->id }}">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.jobs.show', $job) }}">
                                                            <i class="fas fa-eye text-primary"></i> View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.jobs.edit', $job) }}">
                                                            <i class="fas fa-edit text-info"></i> Edit
                                                        </a>
                                                    </li>
                                                    @if($job->status === 'pending' || $job->status === 'featured_pending')
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form action="{{ route('admin.jobs.approve', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Approve this job?');">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item text-success">
                                                                    <i class="fas fa-check"></i> Approve
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @if($job->status === 'featured_pending')
                                                        <li>
                                                            <form action="{{ route('admin.jobs.approve', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Approve as Recommended?');">
                                                                @csrf
                                                                <input type="hidden" name="as_recommended" value="1">
                                                                <button type="submit" class="dropdown-item text-info">
                                                                    <i class="fas fa-thumbs-up"></i> As Recommended
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @endif
                                                        <li>
                                                            <form action="{{ route('admin.jobs.reject', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Reject this job?');">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-times"></i> Reject
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
                                                                    <i class="fas fa-star-half-alt"></i> To Regular
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
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <div class="job-badges mb-2">
                                            @if($job->status == 'published')
                                                <span class="badge-status status-published">Published</span>
                                            @elseif($job->status == 'pending')
                                                <span class="badge-status status-pending">Pending</span>
                                            @elseif($job->status == 'featured_pending')
                                                <span class="badge-status status-featured-pending">Featured Pending</span>
                                            @elseif($job->status == 'draft')
                                                <span class="badge-status status-draft">Draft</span>
                                            @else
                                                <span class="badge-status status-closed">Closed</span>
                                            @endif
                                            @if($job->ad_type === 'featured' || $job->isFeatured())
                                                <span class="badge-status status-featured">
                                                    <i class="fas fa-star"></i> Featured
                                                </span>
                                            @endif
                                            @if($job->category)
                                                <span class="badge-status status-category">{{ Str::limit($job->category->name, 12) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="job-card-body">
                                        <div class="job-info-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ Str::limit($job->location_city, 15) }}, {{ Str::limit($job->location_country, 10) }}</span>
                                        </div>
                                        
                                        @if($job->is_oep_pakistan == 1 && $job->oep_permission_number)
                                            <div class="job-info-item job-info-oep">
                                                <i class="fas fa-certificate"></i>
                                                <span><strong>OEP#:</strong> {{ Str::limit($job->oep_permission_number, 15) }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($job->salary_min || $job->salary_max)
                                            <div class="job-info-item">
                                                <i class="fas fa-dollar-sign"></i>
                                                <span>
                                                    @if($job->salary_min && $job->salary_max)
                                                        {{ number_format($job->salary_min/1000, 0) }}k-{{ number_format($job->salary_max/1000, 0) }}k
                                                    @elseif($job->salary_min)
                                                        From {{ number_format($job->salary_min/1000, 0) }}k
                                                    @else
                                                        Up to {{ number_format($job->salary_max/1000, 0) }}k
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                        
                                        <div class="job-info-item">
                                            <i class="fas fa-users"></i>
                                            <span>{{ $job->applications()->count() }} Applications</span>
                                        </div>
                                    </div>
                                    
                                    <div class="job-card-footer">
                                        <div class="job-footer-info">
                                            <i class="fas fa-calendar"></i>
                                            <span>{{ $job->created_at->format('M j, Y') }}</span>
                                        </div>
                                        <div class="job-footer-actions">
                                            <a href="{{ route('admin.jobs.show', $job) }}" class="btn-action" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.jobs.edit', $job) }}" class="btn-action" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
            @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-briefcase fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted">No jobs found</h5>
                                    <p class="text-muted">No jobs match your current filters.</p>
                                    <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus"></i> Create First Job
                </a>
                                </div>
            </div>
            @endforelse
        </div>
        
                    <!-- Pagination -->
        <div class="row mt-4">
                        <div class="col-md-6">
                <div class="pagination-info">
                    <p class="text-muted mb-0">
                        Showing {{ $jobs->firstItem() ?? 0 }} to {{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} jobs
                    </p>
                </div>
            </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <form method="GET" action="{{ route('admin.jobs.index') }}" class="me-3">
                        @foreach(request()->query() as $key => $value)
                            @if($key !== 'per_page')
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <select name="per_page" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page', 20) == 10 ? 'selected' : '' }}>10 per page</option>
                            <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20 per page</option>
                            <option value="50" {{ request('per_page', 20) == 50 ? 'selected' : '' }}>50 per page</option>
                            <option value="100" {{ request('per_page', 20) == 100 ? 'selected' : '' }}>100 per page</option>
                        </select>
                    </form>
                                <div class="pagination-controls">
                                    {{ $jobs->appends(request()->query())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                </div>
            </div>
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

<style>
/* Compact Job Cards */
.job-card-compact {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 16px;
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.job-card-compact::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.job-card-compact:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    border-color: #667eea;
}

.job-card-compact:hover::before {
    opacity: 1;
}

.job-card-header {
    margin-bottom: 12px;
}

.job-title {
    font-size: 14px;
    font-weight: 600;
    line-height: 1.4;
    margin: 0;
}

.job-title a {
    color: #1f2937;
    text-decoration: none;
    transition: color 0.2s;
}

.job-title a:hover {
    color: #667eea;
}

.job-company {
    font-size: 11px;
    color: #6b7280;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 4px;
}

.job-company i {
    font-size: 10px;
}

.btn-icon {
    background: transparent;
    border: none;
    padding: 4px 8px;
    color: #9ca3af;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.2s;
    font-size: 14px;
}

.btn-icon:hover {
    background: #f3f4f6;
    color: #667eea;
}

.job-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.badge-status {
    display: inline-flex;
    align-items: center;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 600;
    line-height: 1;
    white-space: nowrap;
}

.status-published {
    background: #d1fae5;
    color: #065f46;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.status-featured-pending {
    background: #dbeafe;
    color: #1e40af;
}

.status-draft {
    background: #f3f4f6;
    color: #4b5563;
}

.status-closed {
    background: #fee2e2;
    color: #991b1b;
}

.status-featured {
    background: #fef3c7;
    color: #92400e;
}

.status-featured i {
    font-size: 9px;
    margin-right: 3px;
}

.status-category {
    background: #ede9fe;
    color: #6d28d9;
}

.job-card-body {
    flex: 1;
    margin-bottom: 12px;
}

.job-info-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: #6b7280;
    margin-bottom: 8px;
    line-height: 1.4;
}

.job-info-item:last-child {
    margin-bottom: 0;
}

.job-info-item i {
    font-size: 10px;
    width: 14px;
    color: #9ca3af;
    flex-shrink: 0;
}

.job-info-oep {
    color: #0284c7;
    font-weight: 500;
}

.job-info-oep i {
    color: #0284c7;
}

.job-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 12px;
    border-top: 1px solid #f3f4f6;
    margin-top: auto;
}

.job-footer-info {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 10px;
    color: #9ca3af;
}

.job-footer-info i {
    font-size: 9px;
}

.job-footer-actions {
    display: flex;
    gap: 6px;
}

.btn-action {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    background: #f3f4f6;
    color: #6b7280;
    text-decoration: none;
    transition: all 0.2s;
    font-size: 11px;
}

.btn-action:hover {
    background: #667eea;
    color: #ffffff;
    transform: scale(1.1);
}

/* Responsive Grid */
.col-xl-2-4 {
    flex: 0 0 auto;
    width: 20%;
}

@media (max-width: 1400px) {
    .col-xl-2-4 {
        width: 25%;
    }
}

@media (max-width: 1200px) {
    .col-xl-2-4 {
        width: 33.333333%;
    }
}

@media (max-width: 992px) {
    .col-xl-2-4 {
        width: 50%;
    }
}

@media (max-width: 768px) {
    .col-xl-2-4 {
        width: 100%;
    }
    
    .job-card-compact {
        padding: 14px;
    }
}

/* Statistics Cards */
.avatar-sm {
    width: 3rem;
    height: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-sm i {
    font-size: 1.25rem;
}

.font-20 {
    font-size: 1.25rem;
}

.bg-primary-subtle {
    background-color: rgba(13, 110, 253, 0.1) !important;
}

.bg-warning-subtle {
    background-color: rgba(255, 193, 7, 0.1) !important;
}

.bg-success-subtle {
    background-color: rgba(25, 135, 84, 0.1) !important;
}

.bg-danger-subtle {
    background-color: rgba(220, 53, 69, 0.1) !important;
}

.bg-info-subtle {
    background-color: rgba(13, 202, 240, 0.1) !important;
}

/* Empty State */
.text-center.py-5 {
    padding: 3rem 0;
}
</style>
@endsection
