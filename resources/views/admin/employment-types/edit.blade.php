@extends('layouts.admin')

@section('title', 'Edit Employment Type')
@section('page-title', 'Edit Employment Type')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-edit"></i> Edit Employment Type</h5>
                <a href="{{ route('admin.employment-types.index') }}" class="admin-btn admin-btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to Employment Types
                </a>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.employment-types.update', $employmentType) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="admin-form-group">
                        <label for="name">Employment Type Name *</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="admin-form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $employmentType->name) }}" 
                               required 
                               autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="admin-form-group">
                        <label for="description">Description</label>
                        <textarea id="description" 
                                  name="description" 
                                  class="admin-form-control @error('description') is-invalid @enderror" 
                                  rows="4">{{ old('description', $employmentType->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="admin-form-group">
                        <div class="form-check">
                            <input type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   class="form-check-input" 
                                   {{ old('is_active', $employmentType->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">
                                Active
                            </label>
                        </div>
                    </div>

                    <div class="admin-form-group">
                        <button type="submit" class="admin-btn admin-btn-primary">
                            <i class="fas fa-save"></i> Update Employment Type
                        </button>
                        <a href="{{ route('admin.employment-types.index') }}" class="admin-btn admin-btn-secondary ms-2">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

