@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
.pending-approval-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    transition: all 0.3s;
}

.pending-approval-item:hover {
    background: #ffffff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.pending-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #2773e8 0%, #1e5bb8 100%);
    border-radius: 12px;
    color: #ffffff;
    font-size: 24px;
    flex-shrink: 0;
}

.pending-content {
    flex: 1;
}

.pending-content h4 {
    font-size: 28px;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 5px 0;
}

.pending-content p {
    font-size: 14px;
    color: #718096;
    margin: 0 0 10px 0;
}

.pending-content .btn {
    margin-top: 8px;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="admin-stat-card stat-primary">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['total_users'] }}</h3>
                <p>Total Users</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="admin-stat-card stat-success">
            <div class="stat-icon">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['total_seekers'] }}</h3>
                <p>Job Seekers</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="admin-stat-card stat-info">
            <div class="stat-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['total_employers'] }}</h3>
                <p>Employers</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="admin-stat-card stat-warning">
            <div class="stat-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['total_jobs'] }}</h3>
                <p>Total Jobs</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="admin-stat-card stat-success">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['published_jobs'] }}</h3>
                <p>Published Jobs</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="admin-stat-card stat-secondary">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['pending_jobs'] }}</h3>
                <p>Pending Jobs</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="admin-stat-card stat-primary">
            <div class="stat-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['total_applications'] }}</h3>
                <p>Applications</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="admin-stat-card stat-warning">
            <div class="stat-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['pending_applications'] }}</h3>
                <p>Pending Apps</p>
            </div>
        </div>
    </div>
</div>

<!-- Daily Job Alerts Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-envelope"></i> Daily Job Alerts</h5>
            </div>
            <div class="admin-card-body">
                <p>Send daily job alerts to all registered job seekers manually.</p>
                <form action="{{ route('admin.send-daily-job-alerts.post') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to send daily job alerts to all registered job seekers?')">
                        <i class="fas fa-paper-plane"></i> Send Daily Job Alerts Now
                    </button>
                </form>
                <p class="mt-3 text-muted">
                    <small>
                        <strong>Direct URL (GET):</strong> 
                        <a href="{{ route('admin.send-daily-job-alerts') }}" target="_blank" class="text-primary">
                            {{ route('admin.send-daily-job-alerts') }}
                        </a>
                        <br>
                        <strong>Direct URL (POST):</strong> 
                        <code>{{ route('admin.send-daily-job-alerts.post') }}</code>
                    </small>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Pending Approvals Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-clock"></i> Pending Approvals</h5>
            </div>
            <div class="admin-card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="pending-approval-item">
                            <div class="pending-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="pending-content">
                                <h4>{{ $stats['pending_jobs'] }}</h4>
                                <p>Pending Jobs</p>
                                <a href="{{ route('admin.jobs.index', ['status' => 'pending']) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View All
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="pending-approval-item">
                            <div class="pending-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="pending-content">
                                <h4>{{ $stats['pending_users'] }}</h4>
                                <p>Pending Users</p>
                                <a href="{{ route('admin.users.index', ['status' => 'pending']) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View All
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="pending-approval-item">
                            <div class="pending-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="pending-content">
                                <h4>{{ $stats['pending_documents'] }}</h4>
                                <p>Pending Documents</p>
                                <a href="{{ route('admin.documents.index', ['status' => 'pending']) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View All
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="pending-approval-item">
                            <div class="pending-icon">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div class="pending-content">
                                <h4>{{ $stats['pending_applications'] }}</h4>
                                <p>Pending Applications</p>
                                <a href="{{ route('admin.applications.index', ['status' => 'pending']) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-6 mb-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-users"></i> Recent Users</h5>
            </div>
            <div class="admin-card-body">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td><span class="admin-badge badge-info">{{ ucfirst($user->role->slug) }}</span></td>
                                <td>
                                    @if($user->status == 'active')
                                        <span class="admin-badge badge-success">Active</span>
                                    @else
                                        <span class="admin-badge badge-secondary">{{ ucfirst($user->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No users</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-briefcase"></i> Recent Jobs</h5>
            </div>
            <div class="admin-card-body">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Company</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_jobs as $job)
                            <tr>
                                <td>{{ Str::limit($job->title, 30) }}</td>
                                <td>{{ optional($job->employer->employerProfile)->company_name ?? 'N/A' }}</td>
                                <td>
                                    @if($job->status == 'published')
                                        <span class="admin-badge badge-success">Published</span>
                                    @else
                                        <span class="admin-badge badge-secondary">{{ ucfirst($job->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No jobs</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


