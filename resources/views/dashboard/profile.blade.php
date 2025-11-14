@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<style>
/* Professional Profile Page Styles */
.profile-container {
    background: #f8f9fa;
    min-height: 100vh;
    padding: 20px 0;
}

.profile-header {
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 30px;
    padding: 30px;
}

.profile-info {
    display: flex;
    align-items: center;
    gap: 25px;
    flex-wrap: wrap;
}

.profile-avatar-section {
    position: relative;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.default-avatar-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: #3498db;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 36px;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.profile-details h1 {
    color: #2c3e50;
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 5px 0;
}

.profile-details p {
    color: #7f8c8d;
    font-size: 16px;
    margin: 0 0 10px 0;
}

.profile-badge {
    display: inline-block;
    background: #3498db;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.profile-form-card {
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    padding: 30px;
}

.form-section {
    margin-bottom: 40px;
}

.section-title {
    color: #2c3e50;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    padding-bottom: 10px;
    border-bottom: 2px solid #ecf0f1;
}

.section-title i {
    color: #3498db;
    font-size: 18px;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    color: #2c3e50;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 8px;
    display: block;
}

.form-control {
    border: 2px solid #ecf0f1;
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #ffffff;
}

.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    outline: none;
}

.form-control.is-invalid {
    border-color: #e74c3c;
}

.form-control.is-invalid:focus {
    border-color: #e74c3c;
    box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
}

.invalid-feedback {
    color: #e74c3c;
    font-size: 12px;
    margin-top: 5px;
    display: block;
}

.text-muted {
    color: #7f8c8d !important;
    font-size: 12px;
}

.btn-primary {
    background: #3498db;
    border: none;
    border-radius: 8px;
    padding: 12px 30px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #2980b9;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
}

.alert {
    border-radius: 8px;
    border: none;
    padding: 15px 20px;
    margin-bottom: 25px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
}

.file-upload-info {
    background: #f8f9fa;
    border: 1px solid #ecf0f1;
    border-radius: 6px;
    padding: 10px 15px;
    margin-top: 8px;
    font-size: 12px;
}

.file-upload-info a {
    color: #3498db;
    text-decoration: none;
}

.file-upload-info a:hover {
    text-decoration: underline;
}

.character-count {
    text-align: right;
    font-size: 12px;
    color: #7f8c8d;
    margin-top: 5px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .profile-info {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-form-card {
        padding: 20px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .btn-primary {
        width: 100%;
    }
}
</style>

<section class="profile-container">
    <div class="container">
        <div class="row">
            @include('dashboard.sidebar')
            <div class="col-lg-9">
                <!-- Profile Header -->
                <div class="profile-header">
                    <div class="profile-info">
                        <div class="profile-avatar-section">
                            @php
                                use Illuminate\Support\Facades\Storage;
                                $profileImage = null;
                                
                                if(auth()->user()->isSeeker() && auth()->user()->seekerProfile && auth()->user()->seekerProfile->profile_picture) {
                                    $profileImage = auth()->user()->seekerProfile->profile_picture;
                                } elseif(auth()->user()->isEmployer() && auth()->user()->employerProfile && auth()->user()->employerProfile->company_logo) {
                                    $profileImage = auth()->user()->employerProfile->company_logo;
                                }
                            @endphp
                            
                            @if($profileImage)
                                <img src="{{ asset($profileImage) }}" class="profile-avatar" alt="Profile Picture" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="default-avatar-large" style="display: none;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @else
                                <div class="default-avatar-large">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="profile-details">
                            <h1>{{ auth()->user()->name }}</h1>
                            <p>{{ auth()->user()->email }}</p>
                            <span class="profile-badge">{{ ucfirst(auth()->user()->role->slug) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Profile Form -->
                <div class="profile-form-card">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form id="profileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-user"></i>
                                Basic Information
                            </h3>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" placeholder="Enter your full name" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="Enter your email" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" placeholder="Enter your phone number" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(auth()->user()->isSeeker())
                        <!-- Job Seeker Specific Information -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-briefcase"></i>
                                Professional Information
                            </h3>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name', $user->seekerProfile->full_name ?? '') }}" placeholder="Enter your full name" required>
                                        @error('full_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', $user->seekerProfile && $user->seekerProfile->date_of_birth ? $user->seekerProfile->date_of_birth->format('Y-m-d') : '') }}" max="{{ date('Y-m-d') }}">
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender', $user->seekerProfile->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $user->seekerProfile->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender', $user->seekerProfile->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nationality</label>
                                        <input type="text" name="nationality" class="form-control @error('nationality') is-invalid @enderror" value="{{ old('nationality', $user->seekerProfile->nationality ?? '') }}" placeholder="Enter your nationality">
                                        @error('nationality')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $user->seekerProfile->city ?? '') }}" placeholder="Enter city">
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>State</label>
                                        <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" value="{{ old('state', $user->seekerProfile->state ?? '') }}" placeholder="Enter state">
                                        @error('state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country', $user->seekerProfile->country ?? '') }}" placeholder="Enter country">
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Current Position</label>
                                        <input type="text" name="current_position" class="form-control @error('current_position') is-invalid @enderror" value="{{ old('current_position', $user->seekerProfile->current_position ?? '') }}" placeholder="Enter your current job title">
                                        @error('current_position')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Years of Experience</label>
                                        <input type="text" name="experience_years" class="form-control @error('experience_years') is-invalid @enderror" value="{{ old('experience_years', $user->seekerProfile->experience_years ?? '') }}" placeholder="e.g., 2-5 years">
                                        @error('experience_years')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Expected Salary</label>
                                        <input type="text" name="expected_salary" class="form-control @error('expected_salary') is-invalid @enderror" value="{{ old('expected_salary', $user->seekerProfile->expected_salary ?? '') }}" placeholder="e.g., 10000-15000">
                                        @error('expected_salary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Bio</label>
                                        <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="4" placeholder="Tell us about yourself, your skills, and career goals" maxlength="1000">{{ old('bio', $user->seekerProfile->bio ?? '') }}</textarea>
                                        <div class="character-count">{{ strlen($user->seekerProfile->bio ?? '') }}/1000 characters</div>
                                        @error('bio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documents Section -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-file-alt"></i>
                                Documents
                            </h3>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Profile Picture</label>
                                        <input type="file" id="profile_picture_input" class="form-control @error('profile_picture') is-invalid @enderror" accept="image/*">
                                        <div class="text-muted mt-1">Max 2MB, JPG/PNG format, recommended 400x400</div>
                                        
                                        <!-- Image Cropper Container -->
                                        <div id="image-cropper-container" style="display: none; margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e5e7eb; width: 100%;">
                                            <div id="cropper-preview" style="width: 100%; max-height: 500px; overflow: hidden; background: #f0f0f0; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 20px;"></div>
                                            <div class="row align-items-center">
                                                <div class="col-md-6 text-center mb-3 mb-md-0">
                                                    <h6 style="margin-bottom: 15px; color: #2c3e50; font-weight: 600;">Preview</h6>
                                                    <div id="cropped-preview" style="width: 150px; height: 150px; margin: 0 auto; border: 2px solid #3498db; border-radius: 50%; overflow: hidden; background: #f0f0f0;">
                                                        <img id="cropped-preview-img" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column gap-2">
                                                        <button type="button" id="crop-btn" class="btn btn-primary" style="width: 100%;">
                                                            <i class="fas fa-crop"></i> Crop Image
                                                        </button>
                                                        <button type="button" id="cancel-crop-btn" class="btn btn-secondary" style="width: 100%;">
                                                            <i class="fas fa-times"></i> Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Hidden input for cropped image -->
                                        <input type="hidden" id="cropped_image_data" name="cropped_image_data">
                                        <input type="file" id="profile_picture" name="profile_picture" style="display: none;">
                                        
                                        @if($user->seekerProfile && $user->seekerProfile->profile_picture)
                                            <div class="file-upload-info mt-2">
                                                Current: <a href="{{ asset($user->seekerProfile->profile_picture) }}" target="_blank">View Current Picture</a>
                                            </div>
                                        @endif
                                        @error('profile_picture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Upload CV</label>
                                        <input type="file" name="cv_file" class="form-control @error('cv_file') is-invalid @enderror" accept=".pdf,.doc,.docx">
                                        <div class="text-muted mt-1">Max 5MB, PDF/DOC/DOCX format</div>
                                        @if($user->seekerProfile && $user->seekerProfile->cv_file)
                                            <div class="file-upload-info">
                                                Current: <a href="{{ asset($user->seekerProfile->cv_file) }}" target="_blank">Download Current CV</a>
                                            </div>
                                        @endif
                                        @error('cv_file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(auth()->user()->isEmployer())
                        <!-- Employer Specific Information -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-building"></i>
                                Company Information
                            </h3>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Company Name <span class="text-danger">*</span></label>
                                        <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $user->employerProfile->company_name ?? '') }}" placeholder="Enter company name" required>
                                        @error('company_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Company Website</label>
                                        <input type="url" name="company_website" class="form-control @error('company_website') is-invalid @enderror" value="{{ old('company_website', $user->employerProfile->company_website ?? '') }}" placeholder="https://example.com">
                                        @error('company_website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Industry</label>
                                        <input type="text" name="industry" class="form-control @error('industry') is-invalid @enderror" value="{{ old('industry', $user->employerProfile->industry ?? '') }}" placeholder="Enter industry">
                                        @error('industry')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Company Size</label>
                                        <select name="company_size" class="form-control @error('company_size') is-invalid @enderror">
                                            <option value="">Select Company Size</option>
                                            <option value="1-10" {{ old('company_size', $user->employerProfile->company_size ?? '') == '1-10' ? 'selected' : '' }}>1-10 employees</option>
                                            <option value="11-50" {{ old('company_size', $user->employerProfile->company_size ?? '') == '11-50' ? 'selected' : '' }}>11-50 employees</option>
                                            <option value="51-200" {{ old('company_size', $user->employerProfile->company_size ?? '') == '51-200' ? 'selected' : '' }}>51-200 employees</option>
                                            <option value="201-500" {{ old('company_size', $user->employerProfile->company_size ?? '') == '201-500' ? 'selected' : '' }}>201-500 employees</option>
                                            <option value="500+" {{ old('company_size', $user->employerProfile->company_size ?? '') == '500+' ? 'selected' : '' }}>500+ employees</option>
                                        </select>
                                        @error('company_size')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Founded Year</label>
                                        <input type="number" name="founded_year" class="form-control @error('founded_year') is-invalid @enderror" value="{{ old('founded_year', $user->employerProfile->founded_year ?? '') }}" placeholder="e.g., 2010" min="1900" max="{{ date('Y') }}">
                                        @error('founded_year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Company Description</label>
                                        <textarea name="company_description" class="form-control @error('company_description') is-invalid @enderror" rows="4" placeholder="Describe your company, its mission, and what makes it unique" maxlength="2000">{{ old('company_description', $user->employerProfile->company_description ?? '') }}</textarea>
                                        <div class="character-count">{{ strlen($user->employerProfile->company_description ?? '') }}/2000 characters</div>
                                        @error('company_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Company Logo</label>
                                        <input type="file" id="company_logo_input" class="form-control @error('company_logo') is-invalid @enderror" accept="image/*">
                                        <div class="text-muted mt-1">Max 2MB, JPG/PNG format, recommended 400x400</div>
                                        
                                        <!-- Image Cropper Container for Company Logo -->
                                        <div id="company-logo-cropper-container" style="display: none; margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e5e7eb; width: 100%;">
                                            <div id="company-logo-cropper-preview" style="width: 100%; max-height: 500px; overflow: hidden; background: #f0f0f0; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 20px;"></div>
                                            <div class="row align-items-center">
                                                <div class="col-md-6 text-center mb-3 mb-md-0">
                                                    <h6 style="margin-bottom: 15px; color: #2c3e50; font-weight: 600;">Preview</h6>
                                                    <div id="company-logo-cropped-preview" style="width: 150px; height: 150px; margin: 0 auto; border: 2px solid #3498db; border-radius: 8px; overflow: hidden; background: #f0f0f0;">
                                                        <img id="company-logo-cropped-preview-img" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column gap-2">
                                                        <button type="button" id="crop-company-logo-btn" class="btn btn-primary" style="width: 100%;">
                                                            <i class="fas fa-crop"></i> Crop Logo
                                                        </button>
                                                        <button type="button" id="cancel-company-logo-crop-btn" class="btn btn-secondary" style="width: 100%;">
                                                            <i class="fas fa-times"></i> Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Hidden input for cropped company logo -->
                                        <input type="hidden" id="cropped_company_logo_data" name="cropped_company_logo_data">
                                        <input type="file" id="company_logo" name="company_logo" style="display: none;">
                                        
                                        @if($user->employerProfile && $user->employerProfile->company_logo)
                                            <div class="file-upload-info mt-2">
                                                Current: <a href="{{ asset($user->employerProfile->company_logo) }}" target="_blank">View Current Logo</a>
                                            </div>
                                        @endif
                                        @error('company_logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Submit Button -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileForm');
    
    // Image Cropper functionality
    let cropper = null;
    let cropperImage = null;
    let companyLogoCropper = null;
    let companyLogoImage = null;
    
    const profilePictureInput = document.getElementById('profile_picture_input');
    if (profilePictureInput) {
        profilePictureInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) {
                return;
            }
            
            // Validate file type
            if (!file.type.match('image.*')) {
                alert('Please select a valid image file (JPG or PNG).');
                this.value = '';
                return;
            }
            
            // Validate file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Image size should be less than 2MB.');
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(event) {
                // Destroy previous cropper if exists
                if (cropper) {
                    cropper.destroy();
                }
                
                // Create image element
                const cropperContainer = document.getElementById('cropper-preview');
                if (cropperImage) {
                    cropperImage.remove();
                }
                
                cropperImage = document.createElement('img');
                cropperImage.id = 'cropper-image';
                cropperImage.src = event.target.result;
                cropperContainer.innerHTML = '';
                cropperContainer.appendChild(cropperImage);
                
                // Show cropper container
                document.getElementById('image-cropper-container').style.display = 'block';
                
                // Initialize cropper
                cropper = new Cropper(cropperImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 0.8,
                    responsive: true,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                    ready: function() {
                        updatePreview();
                    }
                });
                
                // Update preview on crop events
                let previewTimeout;
                cropperImage.addEventListener('crop', function() {
                    clearTimeout(previewTimeout);
                    previewTimeout = setTimeout(updatePreview, 100);
                });
                
                cropperImage.addEventListener('cropend', function() {
                    updatePreview();
                });
            };
            reader.readAsDataURL(file);
        });
    }
    
    function updatePreview() {
        if (!cropper) {
            return;
        }
        
        const canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high'
        });
        
        if (canvas) {
            const previewImg = document.getElementById('cropped-preview-img');
            previewImg.src = canvas.toDataURL('image/jpeg', 0.9);
            previewImg.style.display = 'block';
        }
    }
    
    // Crop button click
    const cropBtn = document.getElementById('crop-btn');
    if (cropBtn) {
        cropBtn.addEventListener('click', function() {
            if (!cropper) {
                return;
            }
            
            const canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });
            
            if (canvas) {
                // Convert canvas to blob
                canvas.toBlob(function(blob) {
                    // Create a File object from blob
                    const file = new File([blob], 'profile_picture.jpg', { type: 'image/jpeg' });
                    
                    // Create a DataTransfer object to set the file
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    
                    // Set the file to the hidden input
                    const fileInput = document.getElementById('profile_picture');
                    fileInput.files = dataTransfer.files;
                    
                    // Store base64 for preview
                    const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
                    document.getElementById('cropped_image_data').value = dataUrl;
                    
                    // Hide cropper and show success message
                    document.getElementById('image-cropper-container').style.display = 'none';
                    alert('Image cropped successfully! You can now save your profile.');
                }, 'image/jpeg', 0.9);
            }
        });
    }
    
    // Cancel crop button
    const cancelCropBtn = document.getElementById('cancel-crop-btn');
    if (cancelCropBtn) {
        cancelCropBtn.addEventListener('click', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            if (cropperImage) {
                cropperImage.remove();
                cropperImage = null;
            }
            document.getElementById('image-cropper-container').style.display = 'none';
            document.getElementById('profile_picture_input').value = '';
            document.getElementById('profile_picture').value = '';
            document.getElementById('cropped_image_data').value = '';
            const previewImg = document.getElementById('cropped-preview-img');
            if (previewImg) {
                previewImg.style.display = 'none';
            }
        });
    }
    
    // Company Logo Cropper functionality
    const companyLogoInput = document.getElementById('company_logo_input');
    if (companyLogoInput) {
        companyLogoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) {
                return;
            }
            
            // Validate file type
            if (!file.type.match('image.*')) {
                alert('Please select a valid image file (JPG or PNG).');
                this.value = '';
                return;
            }
            
            // Validate file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Image size should be less than 2MB.');
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(event) {
                // Destroy previous cropper if exists
                if (companyLogoCropper) {
                    companyLogoCropper.destroy();
                }
                
                // Create image element
                const cropperContainer = document.getElementById('company-logo-cropper-preview');
                if (companyLogoImage) {
                    companyLogoImage.remove();
                }
                
                companyLogoImage = document.createElement('img');
                companyLogoImage.id = 'company-logo-cropper-image';
                companyLogoImage.src = event.target.result;
                cropperContainer.innerHTML = '';
                cropperContainer.appendChild(companyLogoImage);
                
                // Show cropper container
                document.getElementById('company-logo-cropper-container').style.display = 'block';
                
                // Initialize cropper
                companyLogoCropper = new Cropper(companyLogoImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 0.8,
                    responsive: true,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                    ready: function() {
                        updateCompanyLogoPreview();
                    }
                });
                
                // Update preview on crop events
                let previewTimeout;
                companyLogoImage.addEventListener('crop', function() {
                    clearTimeout(previewTimeout);
                    previewTimeout = setTimeout(updateCompanyLogoPreview, 100);
                });
                
                companyLogoImage.addEventListener('cropend', function() {
                    updateCompanyLogoPreview();
                });
            };
            reader.readAsDataURL(file);
        });
    }
    
    function updateCompanyLogoPreview() {
        if (!companyLogoCropper) {
            return;
        }
        
        const canvas = companyLogoCropper.getCroppedCanvas({
            width: 400,
            height: 400,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high'
        });
        
        if (canvas) {
            const previewImg = document.getElementById('company-logo-cropped-preview-img');
            previewImg.src = canvas.toDataURL('image/jpeg', 0.9);
            previewImg.style.display = 'block';
        }
    }
    
    // Crop company logo button click
    const cropCompanyLogoBtn = document.getElementById('crop-company-logo-btn');
    if (cropCompanyLogoBtn) {
        cropCompanyLogoBtn.addEventListener('click', function() {
            if (!companyLogoCropper) {
                return;
            }
            
            const canvas = companyLogoCropper.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });
            
            if (canvas) {
                // Convert canvas to blob
                canvas.toBlob(function(blob) {
                    // Create a File object from blob
                    const file = new File([blob], 'company_logo.jpg', { type: 'image/jpeg' });
                    
                    // Create a DataTransfer object to set the file
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    
                    // Set the file to the hidden input
                    const fileInput = document.getElementById('company_logo');
                    fileInput.files = dataTransfer.files;
                    
                    // Store base64 for preview
                    const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
                    document.getElementById('cropped_company_logo_data').value = dataUrl;
                    
                    // Hide cropper and show success message
                    document.getElementById('company-logo-cropper-container').style.display = 'none';
                    alert('Logo cropped successfully! You can now save your profile.');
                }, 'image/jpeg', 0.9);
            }
        });
    }
    
    // Cancel company logo crop button
    const cancelCompanyLogoCropBtn = document.getElementById('cancel-company-logo-crop-btn');
    if (cancelCompanyLogoCropBtn) {
        cancelCompanyLogoCropBtn.addEventListener('click', function() {
            if (companyLogoCropper) {
                companyLogoCropper.destroy();
                companyLogoCropper = null;
            }
            if (companyLogoImage) {
                companyLogoImage.remove();
                companyLogoImage = null;
            }
            document.getElementById('company-logo-cropper-container').style.display = 'none';
            document.getElementById('company_logo_input').value = '';
            document.getElementById('company_logo').value = '';
            document.getElementById('cropped_company_logo_data').value = '';
            const previewImg = document.getElementById('company-logo-cropped-preview-img');
            if (previewImg) {
                previewImg.style.display = 'none';
            }
        });
    }
    
    // Character count for textareas
    const textareas = form.querySelectorAll('textarea[maxlength]');
    textareas.forEach(textarea => {
        const maxLength = textarea.getAttribute('maxlength');
        const counter = textarea.parentNode.querySelector('.character-count');
        
        textarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            counter.textContent = `${currentLength}/${maxLength} characters`;
            
            if (currentLength > maxLength * 0.9) {
                counter.style.color = '#e74c3c';
            } else {
                counter.style.color = '#7f8c8d';
            }
        });
    });
    
    // Form validation
    form.addEventListener('submit', function(e) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        // Email validation
        const emailField = form.querySelector('[type="email"]');
        if (emailField && emailField.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailField.value)) {
                isValid = false;
                emailField.classList.add('is-invalid');
            }
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill all required fields correctly');
        }
    });
});
</script>
@endpush
@endsection
