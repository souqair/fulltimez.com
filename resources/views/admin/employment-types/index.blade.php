@extends('layouts.admin')

@section('title', 'Employment Types')
@section('page-title', 'Employment Types')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h5><i class="fas fa-briefcase"></i> Employment Types</h5>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.employment-types.create') }}" class="admin-btn admin-btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Employment Type
            </a>
            <span class="admin-badge badge-primary">{{ $employmentTypes->total() }} Total</span>
        </div>
    </div>
    <div class="admin-card-body">
        <!-- Employment Types List -->
        <div class="categories-list" id="employmentTypesList">
            @forelse($employmentTypes as $type)
            <div class="category-card" data-type-id="{{ $type->id }}">
                <div class="category-card-content">
                    <div class="category-header">
                        <div class="category-main-info">
                            <div class="category-title-section">
                                <div class="category-title-row">
                                    <h4 class="category-title">
                                        {{ $type->name }}
                                    </h4>
                                    <div class="category-meta-badges">
                                        <span class="meta-badge jobs-badge">
                                            <i class="fas fa-briefcase"></i>
                                            {{ $type->jobPostings()->count() }} Jobs
                                        </span>
                                        <span class="meta-badge slug-badge">
                                            <i class="fas fa-link"></i>
                                            {{ $type->slug }}
                                        </span>
                                    </div>
                                </div>
                                @if($type->description)
                                <div class="category-description">
                                    {{ Str::limit($type->description, 100) }}
                                </div>
                                @endif
                            </div>
                            
                            <div class="category-status-section">
                                @if($type->is_active)
                                    <span class="status-badge active">Active</span>
                                @else
                                    <span class="status-badge inactive">Inactive</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="category-actions">
                            <a href="{{ route('admin.employment-types.edit', $type) }}" class="action-btn edit-btn" title="Edit Employment Type">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.employment-types.destroy', $type) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this employment type?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn" title="Delete Employment Type">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="no-categories">
                <div class="no-categories-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h4>No employment types found</h4>
                <p>There are no employment types available.</p>
                <a href="{{ route('admin.employment-types.create') }}" class="create-btn">
                    <i class="fas fa-plus"></i> Create First Employment Type
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($employmentTypes->hasPages())
        <div class="pagination-wrapper mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="pagination-info">
                    <span class="text-muted">
                        Showing {{ $employmentTypes->firstItem() }} to {{ $employmentTypes->lastItem() }} of {{ $employmentTypes->total() }} employment types
                    </span>
                </div>
                <div class="pagination-controls">
                    {{ $employmentTypes->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

