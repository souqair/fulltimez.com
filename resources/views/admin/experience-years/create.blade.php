@extends('layouts.admin')

@section('title', 'Create Experience Year')
@section('page-title', 'Create Experience Year')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-plus"></i> Create New Experience Year</h5>
                <a href="{{ route('admin.experience-years.index') }}" class="admin-btn admin-btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.experience-years.store') }}" method="POST">
                    @csrf
                    <div class="admin-form-group">
                        <label for="name">Name *</label>
                        <input type="text" id="name" name="name" class="admin-form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus placeholder="e.g., 1 Year, 2 Years, Fresh">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="admin-form-group">
                        <label for="value">Value *</label>
                        <input type="text" id="value" name="value" class="admin-form-control @error('value') is-invalid @enderror" value="{{ old('value') }}" required placeholder="Same as name (for matching)">
                        @error('value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="admin-form-group">
                        <label for="sort_order">Sort Order</label>
                        <input type="number" id="sort_order" name="sort_order" class="admin-form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', 0) }}" min="0">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="admin-form-group">
                        <div class="form-check">
                            <input type="checkbox" id="is_active" name="is_active" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Active</label>
                        </div>
                    </div>
                    <div class="admin-form-group">
                        <button type="submit" class="admin-btn admin-btn-primary">
                            <i class="fas fa-save"></i> Create
                        </button>
                        <a href="{{ route('admin.experience-years.index') }}" class="admin-btn admin-btn-secondary ms-2">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

