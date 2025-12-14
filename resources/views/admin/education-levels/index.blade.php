@extends('layouts.admin')

@section('title', 'Education Levels')
@section('page-title', 'Education Levels')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h5><i class="fas fa-graduation-cap"></i> Education Levels</h5>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.education-levels.create') }}" class="admin-btn admin-btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Education Level
            </a>
            <span class="admin-badge badge-primary">{{ $educationLevels->total() }} Total</span>
        </div>
    </div>
    <div class="admin-card-body">
        <div class="categories-list">
            @forelse($educationLevels as $level)
            <div class="category-card">
                <div class="category-card-content">
                    <div class="category-header">
                        <div class="category-main-info">
                            <div class="category-title-section">
                                <div class="category-title-row">
                                    <h4 class="category-title">{{ $level->name }}</h4>
                                    <div class="category-meta-badges">
                                        <span class="meta-badge jobs-badge">
                                            <i class="fas fa-briefcase"></i>
                                            {{ $level->jobPostings()->count() }} Jobs
                                        </span>
                                        <span class="meta-badge slug-badge">
                                            <i class="fas fa-link"></i>
                                            {{ $level->slug }}
                                        </span>
                                    </div>
                                </div>
                                @if($level->description)
                                <div class="category-description">
                                    {{ Str::limit($level->description, 100) }}
                                </div>
                                @endif
                            </div>
                            <div class="category-status-section">
                                @if($level->is_active)
                                    <span class="status-badge active">Active</span>
                                @else
                                    <span class="status-badge inactive">Inactive</span>
                                @endif
                            </div>
                        </div>
                        <div class="category-actions">
                            <a href="{{ route('admin.education-levels.edit', $level) }}" class="action-btn edit-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.education-levels.destroy', $level) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
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
                <div class="no-categories-icon"><i class="fas fa-graduation-cap"></i></div>
                <h4>No education levels found</h4>
                <a href="{{ route('admin.education-levels.create') }}" class="create-btn">
                    <i class="fas fa-plus"></i> Create First Education Level
                </a>
            </div>
            @endforelse
        </div>
        @if($educationLevels->hasPages())
        <div class="pagination-wrapper mt-4">
            {{ $educationLevels->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

