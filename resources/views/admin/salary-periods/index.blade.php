@extends('layouts.admin')

@section('title', 'Salary Periods')
@section('page-title', 'Salary Periods')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h5><i class="fas fa-clock"></i> Salary Periods</h5>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.salary-periods.create') }}" class="admin-btn admin-btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Salary Period
            </a>
            <span class="admin-badge badge-primary">{{ $periods->total() }} Total</span>
        </div>
    </div>
    <div class="admin-card-body">
        <div class="categories-list">
            @forelse($periods as $period)
            <div class="category-card">
                <div class="category-card-content">
                    <div class="category-header">
                        <div class="category-main-info">
                            <div class="category-title-section">
                                <div class="category-title-row">
                                    <h4 class="category-title">{{ $period->name }}</h4>
                                    <div class="category-meta-badges">
                                        <span class="meta-badge jobs-badge">
                                            <i class="fas fa-briefcase"></i>
                                            {{ $period->jobPostings()->count() }} Jobs
                                        </span>
                                        <span class="meta-badge slug-badge">
                                            <i class="fas fa-link"></i>
                                            {{ $period->slug }}
                                        </span>
                                    </div>
                                </div>
                                @if($period->description)
                                <div class="category-description">
                                    {{ Str::limit($period->description, 100) }}
                                </div>
                                @endif
                            </div>
                            <div class="category-status-section">
                                @if($period->is_active)
                                    <span class="status-badge active">Active</span>
                                @else
                                    <span class="status-badge inactive">Inactive</span>
                                @endif
                            </div>
                        </div>
                        <div class="category-actions">
                            <a href="{{ route('admin.salary-periods.edit', $period) }}" class="action-btn edit-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.salary-periods.destroy', $period) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
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
                <div class="no-categories-icon"><i class="fas fa-clock"></i></div>
                <h4>No salary periods found</h4>
                <a href="{{ route('admin.salary-periods.create') }}" class="create-btn">
                    <i class="fas fa-plus"></i> Create First Salary Period
                </a>
            </div>
            @endforelse
        </div>
        @if($periods->hasPages())
        <div class="pagination-wrapper mt-4">
            {{ $periods->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

