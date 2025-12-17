@extends('layouts.admin')

@section('title', 'Download Resumes')
@section('page-title', 'Download Resumes')

@section('content')
<div class="container-fluid px-4">
    <!-- Header with action buttons -->
    <div class="admin-card mb-4">
        <div class="admin-card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="mb-0">Job Seeker Resumes</h4>
                    <p class="text-muted mb-0">Select resumes to download individually or in bulk</p>
                </div>
                <div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Users
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="admin-card mb-4">
        <div class="admin-card-body">
            <form method="GET" action="{{ route('admin.resumes.index') }}" class="row g-3">
                <div class="col-md-10">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, position, or city..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <a href="{{ route('admin.resumes.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="admin-card mb-4">
        <div class="admin-card-body">
            <form id="bulkDownloadForm" action="{{ route('admin.resumes.bulk-download') }}" method="POST">
                @csrf
                <div id="bulkDownloadCheckboxes" style="display: none;"></div>
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAllResumes">
                            <label class="form-check-label" for="selectAllResumes">
                                <strong>Select All</strong>
                            </label>
                        </div>
                        <span class="text-muted" id="selectedCount">0 selected</span>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary" id="bulkDownloadBtn" disabled>
                            <i class="fas fa-download"></i> Download Selected (ZIP)
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Resumes List -->
    <div class="row g-4">
        @forelse($seekers as $seeker)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="user-card">
                    <div class="user-card-checkbox">
                        <input type="checkbox" class="form-check-input resume-checkbox" name="user_ids[]" value="{{ $seeker->id }}" id="resume_{{ $seeker->id }}" form="bulkDownloadForm">
                    </div>
                    <div class="user-card-header">
                        <div class="user-avatar-wrapper">
                            @if($seeker->seekerProfile && $seeker->seekerProfile->profile_picture)
                                <img src="{{ asset($seeker->seekerProfile->profile_picture) }}" alt="{{ $seeker->name }}" class="user-avatar">
                            @else
                                <div class="user-avatar-default">
                                    {{ strtoupper(substr($seeker->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="user-role-badge role-seeker">
                            <i class="fas fa-user"></i> Seeker
                        </div>
                    </div>
                    
                    <div class="user-card-body">
                        <h5 class="user-name">{{ $seeker->name }}</h5>
                        <p class="user-email">
                            <i class="fas fa-envelope"></i> {{ $seeker->email }}
                        </p>
                        
                        @if($seeker->seekerProfile)
                            <div class="user-info">
                                <i class="fas fa-briefcase"></i>
                                <span>{{ $seeker->seekerProfile->current_position ?? 'Job Seeker' }}</span>
                            </div>
                            @if($seeker->seekerProfile->city)
                            <div class="user-info">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $seeker->seekerProfile->city }}</span>
                            </div>
                            @endif
                        @endif
                        
                        <div class="user-status-badges mt-3">
                            @if($seeker->seekerProfile && $seeker->seekerProfile->cv_file)
                                <span class="status-badge status-approved">
                                    <i class="fas fa-file-pdf"></i> CV Available
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="user-card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.users.download-cv', $seeker) }}" class="btn btn-sm btn-primary flex-fill">
                                <i class="fas fa-download"></i> Download CV
                            </a>
                            <a href="{{ route('admin.users.show', $seeker) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="admin-card">
                    <div class="admin-card-body text-center py-5">
                        <i class="fas fa-file-pdf fa-3x text-muted mb-3"></i>
                        <h5>No resumes found</h5>
                        <p class="text-muted">No job seekers with uploaded CVs found.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-0">
                        Showing {{ $seekers->firstItem() ?? 0 }} to {{ $seekers->lastItem() ?? 0 }} of {{ $seekers->total() }} resumes
                    </p>
                </div>
                <div>
                    {{ $seekers->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAllResumes');
    const resumeCheckboxes = document.querySelectorAll('.resume-checkbox');
    const bulkDownloadBtn = document.getElementById('bulkDownloadBtn');
    const selectedCountSpan = document.getElementById('selectedCount');
    const bulkDownloadForm = document.getElementById('bulkDownloadForm');

    function updateSelectedCount() {
        const selected = document.querySelectorAll('.resume-checkbox:checked').length;
        selectedCountSpan.textContent = selected + ' selected';
        bulkDownloadBtn.disabled = selected === 0;
    }

    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            resumeCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedCount();
        });
    }

    // Individual checkbox change
    resumeCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
            // Update select all checkbox state
            if (selectAllCheckbox) {
                const allChecked = Array.from(resumeCheckboxes).every(cb => cb.checked);
                const someChecked = Array.from(resumeCheckboxes).some(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }
        });
    });

    // Form submission
    if (bulkDownloadForm) {
        bulkDownloadForm.addEventListener('submit', function(e) {
            const selected = document.querySelectorAll('.resume-checkbox:checked').length;
            if (selected === 0) {
                e.preventDefault();
                alert('Please select at least one resume to download.');
                return false;
            }
            
            // Add selected checkboxes to form
            const hiddenInputs = document.getElementById('bulkDownloadCheckboxes');
            hiddenInputs.innerHTML = '';
            document.querySelectorAll('.resume-checkbox:checked').forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'user_ids[]';
                input.value = checkbox.value;
                hiddenInputs.appendChild(input);
            });
        });
    }

    // Initialize count
    updateSelectedCount();
});
</script>
@endpush
@endsection
