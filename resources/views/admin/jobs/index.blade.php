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
                            
                    <!-- Jobs Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle" id="jobsTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;">ID</th>
                                    <th style="width: 20%;">Job Title</th>
                                    <th style="width: 12%;">Company</th>
                                    <th style="width: 10%;">Location</th>
                                    <th style="width: 8%;">Category</th>
                                    <th style="width: 8%;">Status</th>
                                    <th style="width: 8%;">OEP Info</th>
                                    <th style="width: 7%;">Applications</th>
                                    <th style="width: 7%;">Posted Date</th>
                                    <th style="width: 15%;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobs as $job)
                                <tr>
                                    <td>{{ $job->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.jobs.show', $job) }}" class="text-decoration-none fw-semibold">
                                            {{ Str::limit($job->title, 40) }}
                                        </a>
                                        @if($job->ad_type === 'featured' || $job->isFeatured())
                                            <span class="badge bg-warning text-dark ms-1" title="Featured">
                                                <i class="fas fa-star"></i> Featured
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($job->employer && $job->employer->employerProfile)
                                            <small class="text-muted">
                                                <i class="fas fa-building"></i> {{ Str::limit($job->employer->employerProfile->company_name, 25) }}
                                            </small>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>
                                            <i class="fas fa-map-marker-alt text-muted"></i>
                                            {{ Str::limit($job->location_city, 15) }}, {{ Str::limit($job->location_country, 15) }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($job->category)
                                            <span class="badge bg-primary">{{ Str::limit($job->category->name, 15) }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($job->status == 'published')
                                            <span class="badge bg-success">Published</span>
                                        @elseif($job->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($job->status == 'featured_pending')
                                            <span class="badge bg-info">Featured Pending</span>
                                        @elseif($job->status == 'draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @else
                                            <span class="badge bg-danger">Closed</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($job->is_oep_pakistan == 1)
                                            <span class="badge bg-info">OEP: Yes</span>
                                            @if($job->oep_permission_number)
                                                <br><small class="text-info" title="Permission: {{ $job->oep_permission_number }}">
                                                    <i class="fas fa-certificate"></i> {{ Str::limit($job->oep_permission_number, 10) }}
                                                </small>
                                            @endif
                                        @else
                                            <span class="text-muted">No</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-users"></i> {{ $job->applications()->count() }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $job->created_at->format('M j, Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-sm btn-outline-info" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="More Actions">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if($job->status === 'pending' || $job->status === 'featured_pending')
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
                                                            <form action="{{ route('admin.jobs.approve', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Approve this featured request as Recommended (Free) job?');">
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
                                                        <li><hr class="dropdown-divider"></li>
                                                    @endif
                                                    @if($job->status === 'published')
                                                        @if($job->ad_type === 'featured' || $job->isFeatured())
                                                        <li>
                                                            <form action="{{ route('admin.jobs.toggle-featured', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Convert this featured job to regular/recommended?');">
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
                                                        <li><hr class="dropdown-divider"></li>
                                                    @endif
                                                    <li>
                                                        <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this job?');">
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
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <i class="fas fa-briefcase fa-4x text-muted mb-3 d-block"></i>
                                        <h5 class="text-muted">No jobs found</h5>
                                        <p class="text-muted">No jobs match your current filters.</p>
                                        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary mt-3">
                                            <i class="fas fa-plus"></i> Create First Job
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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
/* Table Styles */
#jobsTable {
    font-size: 0.9rem;
}

#jobsTable thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #dee2e6;
    padding: 12px 8px;
    background-color: #f8f9fa;
    position: sticky;
    top: 0;
    z-index: 10;
}

#jobsTable tbody tr {
    transition: background-color 0.2s;
}

#jobsTable tbody tr:hover {
    background-color: #f8f9fa;
}

#jobsTable td {
    padding: 12px 8px;
    vertical-align: middle;
}

#jobsTable .badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
    font-weight: 500;
}

/* Action Buttons */
#jobsTable .btn-group {
    display: flex;
    gap: 2px;
}

#jobsTable .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 0.25rem;
}

#jobsTable .btn-outline-primary:hover {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

#jobsTable .btn-outline-info:hover {
    background-color: #0dcaf0;
    border-color: #0dcaf0;
    color: white;
}

#jobsTable .btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

/* Dropdown Menu */
#jobsTable .dropdown-menu {
    min-width: 200px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(0, 0, 0, 0.15);
}

#jobsTable .dropdown-item {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

#jobsTable .dropdown-item i {
    width: 18px;
    text-align: center;
    margin-right: 8px;
}

/* Status Badges */
.bg-success {
    background-color: #198754 !important;
}

.bg-warning {
    background-color: #ffc107 !important;
    color: #000 !important;
}

.bg-info {
    background-color: #0dcaf0 !important;
}

.bg-secondary {
    background-color: #6c757d !important;
}

.bg-danger {
    background-color: #dc3545 !important;
}

/* Avatar Styles */
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

/* Responsive */
@media (max-width: 1200px) {
    #jobsTable {
        font-size: 0.85rem;
    }
    
    #jobsTable th,
    #jobsTable td {
        padding: 8px 6px;
    }
}

@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto;
    }
    
    #jobsTable {
        font-size: 0.8rem;
    }
    
    #jobsTable .btn-sm {
        padding: 0.2rem 0.4rem;
        font-size: 0.75rem;
    }
}
</style>
@endsection
