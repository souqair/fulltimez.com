@extends('layouts.admin')

@section('title', 'Edit Salary Currency')
@section('page-title', 'Edit Salary Currency')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-edit"></i> Edit Salary Currency</h5>
                <a href="{{ route('admin.salary-currencies.index') }}" class="admin-btn admin-btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.salary-currencies.update', $salaryCurrency) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="admin-form-group">
                        <label for="code">Currency Code * (3 letters)</label>
                        <input type="text" id="code" name="code" class="admin-form-control @error('code') is-invalid @enderror" value="{{ old('code', $salaryCurrency->code) }}" required autofocus maxlength="3">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="admin-form-group">
                        <label for="name">Currency Name *</label>
                        <input type="text" id="name" name="name" class="admin-form-control @error('name') is-invalid @enderror" value="{{ old('name', $salaryCurrency->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="admin-form-group">
                        <label for="symbol">Currency Symbol</label>
                        <input type="text" id="symbol" name="symbol" class="admin-form-control @error('symbol') is-invalid @enderror" value="{{ old('symbol', $salaryCurrency->symbol) }}" maxlength="10">
                        @error('symbol')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="admin-form-group">
                        <div class="form-check">
                            <input type="checkbox" id="is_active" name="is_active" class="form-check-input" {{ old('is_active', $salaryCurrency->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Active</label>
                        </div>
                    </div>
                    <div class="admin-form-group">
                        <button type="submit" class="admin-btn admin-btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('admin.salary-currencies.index') }}" class="admin-btn admin-btn-secondary ms-2">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

