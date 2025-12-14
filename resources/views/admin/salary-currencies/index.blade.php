@extends('layouts.admin')

@section('title', 'Salary Currencies')
@section('page-title', 'Salary Currencies')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h5><i class="fas fa-dollar-sign"></i> Salary Currencies</h5>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.salary-currencies.create') }}" class="admin-btn admin-btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Currency
            </a>
            <span class="admin-badge badge-primary">{{ $currencies->total() }} Total</span>
        </div>
    </div>
    <div class="admin-card-body">
        <div class="categories-list">
            @forelse($currencies as $currency)
            <div class="category-card">
                <div class="category-card-content">
                    <div class="category-header">
                        <div class="category-main-info">
                            <div class="category-title-section">
                                <div class="category-title-row">
                                    <h4 class="category-title">{{ $currency->code }} - {{ $currency->name }}</h4>
                                    <div class="category-meta-badges">
                                        <span class="meta-badge jobs-badge">
                                            <i class="fas fa-briefcase"></i>
                                            {{ $currency->jobPostings()->count() }} Jobs
                                        </span>
                                        @if($currency->symbol)
                                        <span class="meta-badge slug-badge">
                                            <i class="fas fa-symbol"></i>
                                            {{ $currency->symbol }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="category-status-section">
                                @if($currency->is_active)
                                    <span class="status-badge active">Active</span>
                                @else
                                    <span class="status-badge inactive">Inactive</span>
                                @endif
                            </div>
                        </div>
                        <div class="category-actions">
                            <a href="{{ route('admin.salary-currencies.edit', $currency) }}" class="action-btn edit-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.salary-currencies.destroy', $currency) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
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
                <div class="no-categories-icon"><i class="fas fa-dollar-sign"></i></div>
                <h4>No currencies found</h4>
                <a href="{{ route('admin.salary-currencies.create') }}" class="create-btn">
                    <i class="fas fa-plus"></i> Create First Currency
                </a>
            </div>
            @endforelse
        </div>
        @if($currencies->hasPages())
        <div class="pagination-wrapper mt-4">
            {{ $currencies->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

