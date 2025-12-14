@extends('layouts.admin')

@section('title', 'Experience Years')
@section('page-title', 'Experience Years')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h5><i class="fas fa-calendar-alt"></i> Experience Years</h5>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.experience-years.create') }}" class="admin-btn admin-btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Experience Year
            </a>
            <span class="admin-badge badge-primary">{{ $experienceYears->total() }} Total</span>
        </div>
    </div>
    <div class="admin-card-body">
        <div class="categories-list">
            @forelse($experienceYears as $year)
            <div class="category-card">
                <div class="category-card-content">
                    <div class="category-header">
                        <div class="category-main-info">
                            <div class="category-title-section">
                                <div class="category-title-row">
                                    <h4 class="category-title">{{ $year->name }}</h4>
                                    <div class="category-meta-badges">
                                        <span class="meta-badge jobs-badge">
                                            <i class="fas fa-briefcase"></i>
                                            {{ $year->jobPostings()->count() }} Jobs
                                        </span>
                                        <span class="meta-badge slug-badge">
                                            <i class="fas fa-sort"></i>
                                            Order: {{ $year->sort_order }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="category-status-section">
                                @if($year->is_active)
                                    <span class="status-badge active">Active</span>
                                @else
                                    <span class="status-badge inactive">Inactive</span>
                                @endif
                            </div>
                        </div>
                        <div class="category-actions">
                            <a href="{{ route('admin.experience-years.edit', $year) }}" class="action-btn edit-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.experience-years.destroy', $year) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="no-categories">
                <div class="no-categories-icon"><i class="fas fa-calendar-alt"></i></div>
                <h4>No experience years found</h4>
                <a href="{{ route('admin.experience-years.create') }}" class="create-btn">
                    <i class="fas fa-plus"></i> Create First Experience Year
                </a>
            </div>
            @endforelse
        </div>
        @if($experienceYears->hasPages())
        <div class="pagination-wrapper mt-4">
            {{ $experienceYears->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

