@extends('layouts.app')

@section('title', 'Create CV')

@section('content')
<section class="breadcrumb-section">
    <div class="container-auto">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
                <div class="page-title">
                    <h1>Create CV</h1>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create CV</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="pagecontent dashboard_wrap">
    <div class="container">
        <div class="row contactWrp">
            @include('dashboard.sidebar')
            <div class="col-lg-9">
                <div class="card p-5 mt-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 id="heading">Build Your Professional CV</h2>
                            <p>Fill all form fields to create your complete CV</p>
                        </div>
                        @if($profile && $profile->current_position)
                        <div>
                            <a href="{{ route('resume.preview') }}" class="btn btn-info me-2" target="_blank">
                                <i class="fas fa-eye"></i> Preview Resume
                            </a>
                            <a href="{{ route('resume.download') }}" class="btn btn-success">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                        </div>
                        @endif
                    </div>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form id="msform" action="{{ route('seeker.cv.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <ul id="progressbar">
                            <li class="active clickable-step" id="info" data-step="0"><strong>Basic Info</strong></li>
                            <li class="clickable-step" id="bio" data-step="1"><strong>Bio</strong></li>
                            <li class="clickable-step" id="projects" data-step="2"><strong>Projects</strong></li>
                            <li class="clickable-step" id="experience" data-step="3"><strong>Experience</strong></li>
                            <li class="clickable-step" id="education" data-step="4"><strong>Education</strong></li>
                            <li class="clickable-step" id="certificates" data-step="5"><strong>Certificates</strong></li>
                            <li class="clickable-step" id="skills" data-step="6"><strong>Skills</strong></li>
                            <li class="clickable-step" id="submit" data-step="7"><strong>Submit</strong></li>
                        </ul>

                        <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 12.5%;"></div>
                        </div>
                        <br>

                        <!-- Step 1: Basic Info -->
                    <fieldset data-step="basic">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">Basic Information:</h2>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 1 - 8</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="fieldlabels">Current Role <sup>*</sup></label>
                                        <input type="text" class="form-control" name="current_position" value="{{ old('current_position', auth()->user()->seekerProfile->current_position ?? '') }}" placeholder="e.g., Software Engineer" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="fieldlabels">Expected Salary (AED)</label>
                                        <input type="text" class="form-control" name="expected_salary" value="{{ old('expected_salary', $profile->expected_salary ?? '') }}" placeholder="e.g., 5000-8000">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="fieldlabels">Years of Experience <sup>*</sup></label>
                                        <input type="text" class="form-control" name="experience_years" value="{{ old('experience_years', auth()->user()->seekerProfile->experience_years ?? '') }}" placeholder="e.g., 3-5 years" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="fieldlabels">Nationality <sup>*</sup></label>
                                        <select class="form-control" name="nationality" required>
                                            <option value="">-- Select Nationality --</option>
                                            <option value="UAE" {{ old('nationality', auth()->user()->seekerProfile->nationality ?? '') == 'UAE' ? 'selected' : '' }}>UAE</option>
                                            <option value="India" {{ old('nationality', auth()->user()->seekerProfile->nationality ?? '') == 'India' ? 'selected' : '' }}>India</option>
                                            <option value="Pakistan" {{ old('nationality', auth()->user()->seekerProfile->nationality ?? '') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                            <option value="Egypt" {{ old('nationality', auth()->user()->seekerProfile->nationality ?? '') == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                                            <option value="Other" {{ old('nationality', auth()->user()->seekerProfile->nationality ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="fieldlabels">First Language <sup>*</sup></label>
                                        @php
                                            $languages = $profile && $profile->languages ? (is_array($profile->languages) ? $profile->languages : json_decode($profile->languages, true)) : [];
                                            $firstLang = isset($languages[0]) ? $languages[0] : '';
                                            $secondLang = isset($languages[1]) ? $languages[1] : '';
                                        @endphp
                                        <select class="form-control" name="first_language" required>
                                            <option value="">-- Select Language --</option>
                                            <option value="English" {{ old('first_language', $firstLang) == 'English' ? 'selected' : '' }}>English</option>
                                            <option value="Arabic" {{ old('first_language', $firstLang) == 'Arabic' ? 'selected' : '' }}>Arabic</option>
                                            <option value="Hindi" {{ old('first_language', $firstLang) == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                                            <option value="Urdu" {{ old('first_language', $firstLang) == 'Urdu' ? 'selected' : '' }}>Urdu</option>
                                            <option value="French" {{ old('first_language', $firstLang) == 'French' ? 'selected' : '' }}>French</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="fieldlabels">Second Language</label>
                                        <select class="form-control" name="second_language">
                                            <option value="">Select</option>
                                            <option value="English" {{ old('second_language', $secondLang) == 'English' ? 'selected' : '' }}>English</option>
                                            <option value="Arabic" {{ old('second_language', $secondLang) == 'Arabic' ? 'selected' : '' }}>Arabic</option>
                                            <option value="Hindi" {{ old('second_language', $secondLang) == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                                            <option value="Urdu" {{ old('second_language', $secondLang) == 'Urdu' ? 'selected' : '' }}>Urdu</option>
                                            <option value="French" {{ old('second_language', $secondLang) == 'French' ? 'selected' : '' }}>French</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="fieldlabels">Profile Picture</label>
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-3 text-center">
                                                <div style="width: 120px; height: 120px; margin: 0 auto; border: 2px solid #e5e7eb; border-radius: 50%; overflow: hidden; background: #f3f4f6;">
                                                    <img id="current-profile-preview" src="{{ isset($profile) && $profile->profile_picture ? asset($profile->profile_picture) : '' }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover; {{ isset($profile) && $profile->profile_picture ? '' : 'display:none;' }}">
                                                </div>
                                                <small class="text-muted d-block mt-2">Current photo</small>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="file" id="profile_picture_input" class="form-control" accept="image/*" style="margin-bottom: 10px;">
                                                <small class="text-muted">JPG/PNG, recommended 400x400, max ~2MB.</small>

                                                <!-- Image Cropper Container -->
                                                <div id="image-cropper-container" style="display: none; margin-top: 20px;">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div id="cropper-preview" style="max-width: 100%; max-height: 400px; overflow: hidden; background: #f0f0f0; border: 1px solid #ddd; border-radius: 4px;"></div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="text-center">
                                                                <h5>Preview</h5>
                                                                <div id="cropped-preview" style="width: 200px; height: 200px; margin: 0 auto; border: 2px solid #673AB7; border-radius: 50%; overflow: hidden; background: #f0f0f0;">
                                                                    <img id="cropped-preview-img" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                                                </div>
                                                                <div class="mt-3">
                                                                    <button type="button" id="crop-btn" class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-crop"></i> Crop Image
                                                                    </button>
                                                                    <button type="button" id="cancel-crop-btn" class="btn btn-secondary btn-sm mt-2">
                                                                        <i class="fas fa-times"></i> Cancel
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Hidden input for cropped image -->
                                                <input type="hidden" id="cropped_image_data" name="cropped_image_data">
                                                <input type="file" id="profile_picture" name="profile_picture" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <button type="button" class="action-button save-step" style="width: auto; min-width: 150px; padding: 10px 15px; float: left;">Save & Continue</button>
                        <button type="button" class="next action-button next-step">Next</button>
                        </fieldset>

                        <!-- Step 2: Bio -->
                    <fieldset data-step="bio">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-6">
                                        <h2 class="fs-title">Professional Bio:</h2>
                                    </div>
                                    <div class="col-6">
                                        <h2 class="steps">Step 2 - 8</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="fieldlabels">Tell us about yourself <sup>*</sup></label>
                                        <textarea class="form-control" name="bio" rows="8" placeholder="Write a professional summary..." required data-rule-minlength="100" data-rule-maxlength="2000">{{ old('bio', $profile->bio ?? '') }}</textarea>
                                        <small class="text-muted">Minimum 100 characters, Maximum 2000</small>
                                    </div>
                                </div>

                                <!-- Social Media Presence -->
                                @php
                                    $socialLinks = [];
                                    if($profile && isset($profile->social_links)) {
                                        if(is_array($profile->social_links)) {
                                            $socialLinks = $profile->social_links;
                                        } else {
                                            $decoded = json_decode($profile->social_links, true);
                                            if(is_array($decoded)) {
                                                $socialLinks = $decoded;
                                            }
                                        }
                                    }
                                    // Fallback to individual columns
                                    foreach(['linkedin','github','twitter','website','facebook','instagram'] as $key) {
                                        if(empty($socialLinks[$key]) && isset($profile->$key) && !empty($profile->$key)) {
                                            $socialLinks[$key] = $profile->$key;
                                        }
                                    }
                                @endphp
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h5 class="mb-3" style="color:#673AB7;">Social Media Presence (optional)</h5>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="fieldlabels">LinkedIn</label>
                                        <input type="url" class="form-control" name="linkedin" value="{{ old('linkedin', $socialLinks['linkedin'] ?? '') }}" placeholder="https://www.linkedin.com/in/username">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="fieldlabels">GitHub</label>
                                        <input type="url" class="form-control" name="github" value="{{ old('github', $socialLinks['github'] ?? '') }}" placeholder="https://github.com/username">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="fieldlabels">Twitter/X</label>
                                        <input type="url" class="form-control" name="twitter" value="{{ old('twitter', $socialLinks['twitter'] ?? '') }}" placeholder="https://x.com/username">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="fieldlabels">Website/Portfolio</label>
                                        <input type="url" class="form-control" name="website" value="{{ old('website', $socialLinks['website'] ?? '') }}" placeholder="https://your-portfolio.com">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="fieldlabels">Facebook</label>
                                        <input type="url" class="form-control" name="facebook" value="{{ old('facebook', $socialLinks['facebook'] ?? '') }}" placeholder="https://facebook.com/username">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="fieldlabels">Instagram</label>
                                        <input type="url" class="form-control" name="instagram" value="{{ old('instagram', $socialLinks['instagram'] ?? '') }}" placeholder="https://instagram.com/username">
                                    </div>
                                </div>
                            </div>
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous">
                        <button type="button" class="action-button save-step" style="width: auto; min-width: 150px; padding: 10px 15px;">Save & Continue</button>
                        <button type="button" class="next action-button next-step">Next</button>
                        </fieldset>

                        <!-- Step 3: Projects (Multiple) -->
                    <fieldset data-step="projects">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-6">
                                        <h2 class="fs-title">Projects:</h2>
                                    </div>
                                    <div class="col-6">
                                        <h2 class="steps">Step 3 - 8</h2>
                                    </div>
                                </div>
                                <div id="projects-container">
                                    @forelse($projects as $index => $project)
                                    <div class="project-item mb-4 p-3 border rounded position-relative">
                                        @if($index > 0)
                                        <button type="button" class="btn btn-sm btn-danger remove-item-btn" onclick="$(this).parent().remove()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Project Name</label>
                                                <input type="text" class="form-control" name="projects[{{ $index }}][name]" value="{{ old('projects.'.$index.'.name', $project->project_name) }}" placeholder="Project Name">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Project Type</label>
                                                <input type="text" class="form-control" name="projects[{{ $index }}][type]" value="{{ old('projects.'.$index.'.type', $project->project_type) }}" placeholder="Web App, Mobile App, etc.">
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="fieldlabels">Project Link</label>
                                                <input type="url" class="form-control" name="projects[{{ $index }}][link]" value="{{ old('projects.'.$index.'.link', $project->project_link) }}" placeholder="https://example.com">
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="fieldlabels">Description</label>
                                                <textarea class="form-control" name="projects[{{ $index }}][description]" rows="2" placeholder="Brief description">{{ old('projects.'.$index.'.description', $project->description) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="project-item mb-4 p-3 border rounded">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Project Name</label>
                                                <input type="text" class="form-control" name="projects[0][name]" placeholder="Project Name">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Project Type</label>
                                                <input type="text" class="form-control" name="projects[0][type]" placeholder="Web App, Mobile App, etc.">
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="fieldlabels">Project Link</label>
                                                <input type="url" class="form-control" name="projects[0][link]" placeholder="https://example.com">
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="fieldlabels">Description</label>
                                                <textarea class="form-control" name="projects[0][description]" rows="2" placeholder="Brief description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addProject()"><i class="fas fa-plus"></i> Add Another Project</button>
                            </div>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous">
                    <button type="button" class="action-button save-step" style="width: auto; min-width: 150px; padding: 10px 15px;">Save & Continue</button>
                    <button type="button" class="next action-button next-step">Next</button>
                        </fieldset>

                        <!-- Step 4: Experience (Multiple) -->
                    <fieldset data-step="experience">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-6">
                                        <h2 class="fs-title">Work Experience:</h2>
                                    </div>
                                    <div class="col-6">
                                        <h2 class="steps">Step 4 - 8</h2>
                                    </div>
                                </div>
                                <div id="experience-container">
                                    @forelse($experiences as $index => $exp)
                                    <div class="experience-item mb-4 p-3 border rounded position-relative">
                                        @if($index > 0)
                                        <button type="button" class="btn btn-sm btn-danger remove-item-btn" onclick="$(this).parent().remove()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Company Name</label>
                                                <input type="text" class="form-control" name="experience[{{ $index }}][company]" value="{{ old('experience.'.$index.'.company', $exp->company_name) }}" placeholder="Company Name">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Job Title</label>
                                                <input type="text" class="form-control" name="experience[{{ $index }}][title]" value="{{ old('experience.'.$index.'.title', $exp->job_title) }}" placeholder="Your Position">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Start Date</label>
                                                <input type="date" class="form-control" name="experience[{{ $index }}][start_date]" value="{{ old('experience.'.$index.'.start_date', $exp->start_date ? $exp->start_date->format('Y-m-d') : '') }}">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">End Date (Leave empty if current)</label>
                                                <input type="date" class="form-control" name="experience[{{ $index }}][end_date]" value="{{ old('experience.'.$index.'.end_date', $exp->end_date ? $exp->end_date->format('Y-m-d') : '') }}">
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="fieldlabels">Description</label>
                                                <textarea class="form-control" name="experience[{{ $index }}][description]" rows="2" placeholder="Your responsibilities">{{ old('experience.'.$index.'.description', $exp->description) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="experience-item mb-4 p-3 border rounded">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Company Name</label>
                                                <input type="text" class="form-control" name="experience[0][company]" placeholder="Company Name">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Job Title</label>
                                                <input type="text" class="form-control" name="experience[0][title]" placeholder="Your Position">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Start Date</label>
                                                <input type="date" class="form-control" name="experience[0][start_date]">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">End Date (Leave empty if current)</label>
                                                <input type="date" class="form-control" name="experience[0][end_date]">
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="fieldlabels">Description</label>
                                                <textarea class="form-control" name="experience[0][description]" rows="2" placeholder="Your responsibilities"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addExperience()"><i class="fas fa-plus"></i> Add Another Experience</button>
                            </div>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous">
                    <button type="button" class="action-button save-step" style="width: auto; min-width: 150px; padding: 10px 15px;">Save & Continue</button>
                    <button type="button" class="next action-button next-step">Next</button>
                        </fieldset>

                        <!-- Step 5: Education (Multiple) -->
                    <fieldset data-step="education">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-6">
                                        <h2 class="fs-title">Education:</h2>
                                    </div>
                                    <div class="col-6">
                                        <h2 class="steps">Step 5 - 8</h2>
                                    </div>
                                </div>
                                <div id="education-container">
                                    @forelse($educations as $index => $edu)
                                    <div class="education-item mb-4 p-3 border rounded position-relative">
                                        @if($index > 0)
                                        <button type="button" class="btn btn-sm btn-danger remove-item-btn" onclick="$(this).parent().remove()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Institution Name</label>
                                                <input type="text" class="form-control" name="education[{{ $index }}][institution]" value="{{ old('education.'.$index.'.institution', $edu->institution_name) }}" placeholder="University/School">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Degree</label>
                                                <select class="form-control" name="education[{{ $index }}][degree]">
                                                    <option value="">Select</option>
                                                    <option value="High School" {{ old('education.'.$index.'.degree', $edu->degree) == 'High School' ? 'selected' : '' }}>High School</option>
                                                    <option value="Diploma" {{ old('education.'.$index.'.degree', $edu->degree) == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                                    <option value="Vocational" {{ old('education.'.$index.'.degree', $edu->degree) == 'Vocational' ? 'selected' : '' }}>Vocational</option>
                                                    <option value="Bachelor's" {{ old('education.'.$index.'.degree', $edu->degree) == "Bachelor's" ? 'selected' : '' }}>Bachelor's</option>
                                                    <option value="Master's" {{ old('education.'.$index.'.degree', $edu->degree) == "Master's" ? 'selected' : '' }}>Master's</option>
                                                    <option value="PhD" {{ old('education.'.$index.'.degree', $edu->degree) == 'PhD' ? 'selected' : '' }}>PhD</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Field of Study</label>
                                                <input type="text" class="form-control" name="education[{{ $index }}][field]" value="{{ old('education.'.$index.'.field', $edu->field_of_study) }}" placeholder="e.g., Computer Science">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Graduation Year</label>
                                                <input type="number" class="form-control" name="education[{{ $index }}][year]" value="{{ old('education.'.$index.'.year', $edu->end_date ? $edu->end_date->format('Y') : '') }}" placeholder="e.g., 2020" min="1950" max="{{ date('Y') + 10 }}">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Start Date</label>
                                                <input type="date" class="form-control" name="education[{{ $index }}][start_date]" value="{{ old('education.'.$index.'.start_date', $edu->start_date ? $edu->start_date->format('Y-m-d') : '') }}">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">End Date</label>
                                                <input type="date" class="form-control" name="education[{{ $index }}][end_date]" value="{{ old('education.'.$index.'.end_date', $edu->end_date ? $edu->end_date->format('Y-m-d') : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="education-item mb-4 p-3 border rounded">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Institution Name</label>
                                                <input type="text" class="form-control" name="education[0][institution]" placeholder="University/School">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Degree</label>
                                                <select class="form-control" name="education[0][degree]">
                                                    <option value="">Select</option>
                                                    <option value="High School">High School</option>
                                                    <option value="Diploma">Diploma</option>
                                                    <option value="Vocational">Vocational</option>
                                                    <option value="Bachelor's">Bachelor's</option>
                                                    <option value="Master's">Master's</option>
                                                    <option value="PhD">PhD</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Field of Study</label>
                                                <input type="text" class="form-control" name="education[0][field]" placeholder="e.g., Computer Science">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Graduation Year</label>
                                                <input type="number" class="form-control" name="education[0][year]" placeholder="e.g., 2020" min="1950" max="{{ date('Y') + 10 }}">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">Start Date</label>
                                                <input type="date" class="form-control" name="education[0][start_date]">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="fieldlabels">End Date</label>
                                                <input type="date" class="form-control" name="education[0][end_date]">
                                            </div>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addEducation()"><i class="fas fa-plus"></i> Add Another Education</button>
                            </div>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous">
                    <button type="button" class="action-button save-step" style="width: auto; min-width: 150px; padding: 10px 15px;">Save & Continue</button>
                    <button type="button" class="next action-button next-step">Next</button>
                        </fieldset>

                        <!-- Step 6: Certificates (Multiple) -->
                    <fieldset data-step="certificates">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-6">
                                        <h2 class="fs-title">Certificates:</h2>
                                    </div>
                                    <div class="col-6">
                                        <h2 class="steps">Step 6 - 8</h2>
                                    </div>
                                </div>
                                <div id="certificates-container">
                                    @forelse($certificates as $index => $cert)
                                    <div class="certificate-item mb-4 p-3 border rounded position-relative">
                                        @if($index > 0)
                                        <button type="button" class="btn btn-sm btn-danger remove-item-btn" onclick="$(this).parent().remove()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label class="fieldlabels">Certificate Name</label>
                                                <input type="text" class="form-control" name="certificates[{{ $index }}][name]" value="{{ old('certificates.'.$index.'.name', $cert->certificate_name) }}" placeholder="Certificate Name">
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="fieldlabels">Issuing Organization</label>
                                                <input type="text" class="form-control" name="certificates[{{ $index }}][organization]" value="{{ old('certificates.'.$index.'.organization', $cert->issuing_organization) }}" placeholder="Organization Name">
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="fieldlabels">Issue Date</label>
                                                <input type="date" class="form-control" name="certificates[{{ $index }}][date]" value="{{ old('certificates.'.$index.'.date', $cert->issue_date ? $cert->issue_date->format('Y-m-d') : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="certificate-item mb-4 p-3 border rounded">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label class="fieldlabels">Certificate Name</label>
                                                <input type="text" class="form-control" name="certificates[0][name]" placeholder="Certificate Name">
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="fieldlabels">Issuing Organization</label>
                                                <input type="text" class="form-control" name="certificates[0][organization]" placeholder="Organization Name">
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="fieldlabels">Issue Date</label>
                                                <input type="date" class="form-control" name="certificates[0][date]">
                                            </div>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addCertificate()"><i class="fas fa-plus"></i> Add Another Certificate</button>
                            </div>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous">
                    <button type="button" class="action-button save-step" style="width: auto; min-width: 150px; padding: 10px 15px;">Save & Continue</button>
                    <button type="button" class="next action-button next-step">Next</button>
                        </fieldset>

                        <!-- Step 7: Skills (Tags) -->
                    <fieldset data-step="skills">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-6">
                                        <h2 class="fs-title">Your Skills:</h2>
                                    </div>
                                    <div class="col-6">
                                        <h2 class="steps">Step 7 - 8</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="fieldlabels">Add your skills <sup>*</sup></label>
                                        @php
                                            $existingSkills = '';
                                            if($profile && $profile->skills) {
                                                $skillsArray = is_array($profile->skills) ? $profile->skills : json_decode($profile->skills, true);
                                                $existingSkills = is_array($skillsArray) ? implode(',', $skillsArray) : '';
                                            }
                                        @endphp
                                        <input type="text" id="skills-input" class="form-control" name="skills" value="{{ old('skills', $existingSkills) }}" placeholder="Type skill and press Enter (e.g., PHP)" data-rule-required="true">
                                        <small class="text-muted d-block mt-2">
                                            <strong>How to add skills:</strong><br>
                                            1. Type skill name (e.g., "PHP")<br>
                                            2. Press <kbd>Enter</kbd> or <kbd>,</kbd> (comma)<br>
                                            3. Purple tag will appear<br>
                                            4. Repeat to add more skills
                                        </small>
                                        <div id="skills-debug" class="alert alert-info mt-2" style="display:none;">
                                            <small>Debug: <span id="skills-count">0</span> skills added</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous">
                        <button type="button" class="action-button save-step" style="width: auto; min-width: 150px; padding: 10px 15px;">Save & Continue</button>
                        <button type="button" class="next action-button next-step">Next</button>
                        </fieldset>

                        <!-- Step 8: Submit -->
                    <fieldset data-step="submit">
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-6">
                                        <h2 class="fs-title">Finish:</h2>
                                    </div>
                                    <div class="col-6">
                                        <h2 class="steps">Step 8 - 8</h2>
                                    </div>
                                </div>
                                <br><br>
                                <h2 class="purple-text text-center"><strong>READY TO SUBMIT!</strong></h2>
                                <br>
                                <div class="row justify-content-center">
                                    <div class="col-3">
                                        <img src="https://i.imgur.com/GwStPmg.png" class="fit-image">
                                    </div>
                                </div>
                                <br><br>
                                <div class="row justify-content-center">
                                    <div class="col-7 text-center">
                                        <h5 class="purple-text text-center">Click Submit to Create Your CV</h5>
                                    <button type="button" class="btn btn-success btn-lg mt-3 final-submit">
                                            <i class="fas fa-check"></i> Submit CV
                                        </button>
                                    </div>
                                </div>
                            </div>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<style>
.tagify {
    --tag-bg: #673AB7;
    --tag-hover: #5E35B1;
    --tag-text-color: #fff;
    min-height: 80px;
}
.remove-item-btn {
    position: absolute;
    top: 10px;
    right: 10px;
}

/* Image Cropper Styles */
#cropper-preview {
    min-height: 300px;
}

#cropper-preview img {
    max-width: 100%;
    display: block;
}

#cropped-preview {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Button refinement - keep positions and classes the same */
#msform .action-button,
#msform .next.action-button {
    display: inline-block;
    min-width: 140px;
    padding: 10px 16px;
    background: #673AB7;
    border: 1px solid #673AB7;
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
    line-height: 1.2;
    text-transform: none;
    box-shadow: none;
    transition: background .2s ease, box-shadow .2s ease, transform .05s ease;
}
#msform .action-button:hover,
#msform .next.action-button:hover {
    background: #5E35B1;
    box-shadow: 0 4px 12px rgba(103, 58, 183, 0.25);
}
#msform .action-button:active,
#msform .next.action-button:active {
    transform: translateY(1px);
}
#msform .action-button-previous {
    display: inline-block;
    min-width: 120px;
    padding: 10px 16px;
    background: #6b7280;
    border: 1px solid #6b7280;
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
    line-height: 1.2;
    box-shadow: none;
    transition: background .2s ease, box-shadow .2s ease, transform .05s ease;
}
#msform .action-button-previous:hover {
    background: #52525b;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
/*
let projectCount = {{ $projects->count() > 0 ? $projects->count() : 1 }};
let experienceCount = {{ $experiences->count() > 0 ? $experiences->count() : 1 }};
let educationCount = {{ $educations->count() > 0 ? $educations->count() : 1 }};
let certificateCount = {{ $certificates->count() > 0 ? $certificates->count() : 1 }};

// Image Cropper functionality
let cropper = null;
let cropperImage = null;

$('#profile_picture_input').on('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Validate file type
        if (!file.type.match('image.*')) {
            alert('Please select an image file.');
            $(this).val('');
            return;
        }
        
        // Validate file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Image size should be less than 2MB.');
            $(this).val('');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(event) {
            // Destroy previous cropper if exists
            if (cropper) {
                cropper.destroy();
            }
            
            // Create image element
            if (cropperImage) {
                cropperImage.remove();
            }
            cropperImage = $('<img>').attr('id', 'cropper-image').attr('src', event.target.result);
            $('#cropper-preview').html(cropperImage);
            
            // Show cropper container
            $('#image-cropper-container').show();
            
            // Initialize cropper
            cropper = new Cropper(cropperImage[0], {
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
            cropperImage[0].addEventListener('crop', function() {
                clearTimeout(previewTimeout);
                previewTimeout = setTimeout(updatePreview, 100);
            });
            
            cropperImage[0].addEventListener('cropend', function() {
                updatePreview();
            });
        };
        reader.readAsDataURL(file);
    }
});

function updatePreview() {
    if (cropper) {
        const canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high'
        });
        
        if (canvas) {
            const previewImg = $('#cropped-preview-img');
            previewImg.attr('src', canvas.toDataURL('image/jpeg', 0.9));
            previewImg.show();
        }
    }
}

// Crop button click
$('#crop-btn').on('click', function() {
    if (cropper) {
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
                $('#cropped_image_data').val(dataUrl);
                
                // Update current preview on the form immediately
                const currentPreview = document.getElementById('current-profile-preview');
                if (currentPreview) {
                    currentPreview.src = dataUrl;
                    currentPreview.style.display = '';
                }
                
                // Hide cropper and show success message
                $('#image-cropper-container').hide();
                alert('Image cropped successfully!');
            }, 'image/jpeg', 0.9);
        }
    }
});

// Cancel crop button
$('#cancel-crop-btn').on('click', function() {
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
    if (cropperImage) {
        cropperImage.remove();
        cropperImage = null;
    }
    $('#image-cropper-container').hide();
    $('#profile_picture_input').val('');
    $('#profile_picture').val('');
    $('#cropped_image_data').val('');
    $('#cropped-preview-img').hide();
});

function addProject() {
    const container = $('#projects-container');
    const html = `
        <div class="project-item mb-4 p-3 border rounded position-relative">
            <button type="button" class="btn btn-sm btn-danger remove-item-btn" onclick="$(this).parent().remove()">
                <i class="fas fa-times"></i>
            </button>
            <div class="row">
                <div class="col-lg-6">
                    <label class="fieldlabels">Project Name</label>
                    <input type="text" class="form-control" name="projects[${projectCount}][name]" placeholder="Project Name">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">Project Type</label>
                    <input type="text" class="form-control" name="projects[${projectCount}][type]" placeholder="Web App, Mobile App, etc.">
                </div>
                <div class="col-lg-12">
                    <label class="fieldlabels">Project Link</label>
                    <input type="url" class="form-control" name="projects[${projectCount}][link]" placeholder="https://example.com">
                </div>
                <div class="col-lg-12">
                    <label class="fieldlabels">Description</label>
                    <textarea class="form-control" name="projects[${projectCount}][description]" rows="2" placeholder="Brief description"></textarea>
                </div>
            </div>
        </div>
    `;
    container.append(html);
    projectCount++;
}

function addExperience() {
    const container = $('#experience-container');
    const html = `
        <div class="experience-item mb-4 p-3 border rounded position-relative">
            <button type="button" class="btn btn-sm btn-danger remove-item-btn" onclick="$(this).parent().remove()">
                <i class="fas fa-times"></i>
            </button>
            <div class="row">
                <div class="col-lg-6">
                    <label class="fieldlabels">Company Name</label>
                    <input type="text" class="form-control" name="experience[${experienceCount}][company]" placeholder="Company Name">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">Job Title</label>
                    <input type="text" class="form-control" name="experience[${experienceCount}][title]" placeholder="Your Position">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">Start Date</label>
                    <input type="date" class="form-control" name="experience[${experienceCount}][start_date]">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">End Date</label>
                    <input type="date" class="form-control" name="experience[${experienceCount}][end_date]">
                </div>
                <div class="col-lg-12">
                    <label class="fieldlabels">Description</label>
                    <textarea class="form-control" name="experience[${experienceCount}][description]" rows="2" placeholder="Your responsibilities"></textarea>
                </div>
            </div>
        </div>
    `;
    container.append(html);
    experienceCount++;
}

function addEducation() {
    const container = $('#education-container');
    const html = `
        <div class="education-item mb-4 p-3 border rounded position-relative">
            <button type="button" class="btn btn-sm btn-danger remove-item-btn" onclick="$(this).parent().remove()">
                <i class="fas fa-times"></i>
            </button>
            <div class="row">
                <div class="col-lg-6">
                    <label class="fieldlabels">Institution Name</label>
                    <input type="text" class="form-control" name="education[${educationCount}][institution]" placeholder="University/School">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">Degree</label>
                    <select class="form-control" name="education[${educationCount}][degree]">
                        <option value="">Select</option>
                        <option value="High School">High School</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Vocational">Vocational</option>
                        <option value="Bachelor's">Bachelor's</option>
                        <option value="Master's">Master's</option>
                        <option value="PhD">PhD</option>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">Field of Study</label>
                    <input type="text" class="form-control" name="education[${educationCount}][field]" placeholder="e.g., Computer Science">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">Graduation Year</label>
                    <input type="number" class="form-control" name="education[${educationCount}][year]" placeholder="e.g., 2020" min="1950" max="{{ date('Y') + 10 }}">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">Start Date</label>
                    <input type="date" class="form-control" name="education[${educationCount}][start_date]">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">End Date</label>
                    <input type="date" class="form-control" name="education[${educationCount}][end_date]">
                </div>
            </div>
        </div>
    `;
    container.append(html);
    educationCount++;
}

function addCertificate() {
    const container = $('#certificates-container');
    const html = `
        <div class="certificate-item mb-4 p-3 border rounded position-relative">
            <button type="button" class="btn btn-sm btn-danger remove-item-btn" onclick="$(this).parent().remove()">
                <i class="fas fa-times"></i>
            </button>
            <div class="row">
                <div class="col-lg-12">
                    <label class="fieldlabels">Certificate Name</label>
                    <input type="text" class="form-control" name="certificates[${certificateCount}][name]" placeholder="Certificate Name">
                </div>
                <div class="col-lg-12">
                    <label class="fieldlabels">Issuing Organization</label>
                    <input type="text" class="form-control" name="certificates[${certificateCount}][organization]" placeholder="Organization Name">
                </div>
                <div class="col-lg-12">
                    <label class="fieldlabels">Issue Date</label>
                    <input type="date" class="form-control" name="certificates[${certificateCount}][date]">
                </div>
            </div>
        </div>
    `;
    container.append(html);
    certificateCount++;
}

$(document).ready(function(){
    var current_fs, next_fs, previous_fs;
    var current = 1;
    var steps = 8;

    // Helper to jump to a specific step index (0-based)
    function goToStep(index) {
        const $fieldsets = $('#msform fieldset');
        const $target = $fieldsets.eq(index);
        if (!$target.length) return;

        // Hide all, show target
        $fieldsets.hide().css({ opacity: 1 });
        $target.show().css({ opacity: 1 });

        // Update progress classes
        $("#progressbar li").removeClass("active");
        $("#progressbar li").each(function(i) {
            if (i <= index) $(this).addClass("active");
        });

        // Update current and progress bar
        current = index + 1;
        setProgressBar(current);
    }

    // Restore last step from localStorage (default 0)
    var savedIndex = localStorage.getItem('cvCurrentStep');
    if (savedIndex !== null) {
        var idx = parseInt(savedIndex, 10);
        if (!isNaN(idx) && idx >= 0 && idx < steps) {
            goToStep(idx);
        } else {
            setProgressBar(current);
        }
    } else {
        setProgressBar(current);
    }

    // Initialize Tagify
    var input = document.getElementById('skills-input');
    
    // Make sure Tagify is loaded
    if (typeof Tagify === 'undefined') {
        console.error('Tagify library not loaded!');
        alert('Error loading skills input. Please refresh the page.');
    }
    
    var tagify = new Tagify(input, {
        originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(','),
        delimiters: ",|;",
        maxTags: 30,
        dropdown: {
            enabled: 0
        },
        callbacks: {
            add: function() {
                // Update original input whenever tag is added
                const skills = tagify.value.map(item => item.value).join(',');
                input.value = skills;
                console.log('Input updated on add:', input.value);
            },
            remove: function() {
                // Update original input whenever tag is removed
                const skills = tagify.value.map(item => item.value).join(',');
                input.value = skills;
                console.log('Input updated on remove:', input.value);
            }
        }
    });
    
    // Load existing skills into Tagify (if any)
    const initialSkills = input.value;
    if (initialSkills && initialSkills.trim() !== '') {
        console.log('Loading existing skills:', initialSkills);
        // Tagify automatically parses comma-separated values
        tagify.addTags(initialSkills);
        console.log('Loaded skills count:', tagify.value.length);
        $('#skills-debug').show();
        $('#skills-count').text(tagify.value.length);
    }
    
    // Debug: Log when tag is added
    tagify.on('add', function(e) {
        console.log('✅ Tag added:', e.detail.data.value);
        console.log('Current tags:', tagify.value);
        console.log('Input value:', input.value);
        $('#skills-debug').show();
        $('#skills-count').text(tagify.value.length);
    });
    
    // Debug: Log when tag is removed
    tagify.on('remove', function(e) {
        console.log('❌ Tag removed:', e.detail.data.value);
        console.log('Remaining tags:', tagify.value);
        $('#skills-count').text(tagify.value.length);
        if (tagify.value.length === 0) {
            $('#skills-debug').hide();
        }
    });

    $(".next").click(function(){
        const currentFieldset = $(this).parent();
        const requiredFields = currentFieldset.find('[required]');
        let isValid = true;
        let missingFields = [];

        requiredFields.each(function() {
            const fieldValue = $(this).val();
            const fieldName = $(this).prev('label').text() || $(this).attr('name');
            
            // Check if value is empty or just whitespace
            if (!fieldValue || fieldValue.trim() === '' || fieldValue === 'Select') {
                isValid = false;
                $(this).addClass('is-invalid');
                missingFields.push(fieldName);
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Step 2: Bio validation (min 100 chars)
        if (current === 2) {
            const bioField = currentFieldset.find('[name="bio"]');
            const bioValue = bioField.val() || '';
            if (bioValue.length < 100) {
                isValid = false;
                alert('Bio must be at least 100 characters. Current: ' + bioValue.length + ' characters');
                bioField.addClass('is-invalid').focus();
                return false;
            }
        }

        // Step 7: Skills validation
        if (current === 7) {
            // Force update input value from Tagify
            if (tagify && tagify.value.length > 0) {
                const skillsString = tagify.value.map(item => item.value).join(',');
                $('#skills-input').val(skillsString);
            }
            
            const skillsValue = $('#skills-input').val();
            console.log('Step 7 validation:');
            console.log('- Tagify count:', tagify.value.length);
            console.log('- Input value:', skillsValue);
            
            if (tagify.value.length === 0) {
                isValid = false;
                alert('Please add at least one skill.\n\nHow to add:\n1. Type skill name\n2. Press Enter or Comma\n3. Tag will appear in purple\n\nCurrent tags: ' + tagify.value.length);
                $('#skills-input').focus();
                return false;
            }
        }

        if (!isValid) {
            if (missingFields.length > 0) {
                alert('Please fill the following required fields:\n- ' + missingFields.join('\n- '));
            } else {
                alert('Please fill all required fields marked with *');
            }
            return false;
        }

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        next_fs.show();
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                current_fs.css({'display': 'none', 'position': 'relative'});
                next_fs.css({'opacity': 1 - now});
            },
            duration: 500
        });
        setProgressBar(++current);
    });

    $(".previous").click(function(){
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        previous_fs.show();
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                current_fs.css({'display': 'none', 'position': 'relative'});
                previous_fs.css({'opacity': 1 - now});
            },
            duration: 500
        });
        setProgressBar(--current);
    });

    // Save & Continue button handler
    $('input[name="save"]').click(function(e){
        e.preventDefault();
        const saveButton = $(this);
        const currentFieldset = saveButton.parent();
        const requiredFields = currentFieldset.find('[required]');
        let isValid = true;
        let missingFields = [];

        // Validate required fields
        requiredFields.each(function() {
            const fieldValue = $(this).val();
            const fieldName = $(this).prev('label').text() || $(this).attr('name');
            
            if (!fieldValue || fieldValue.trim() === '' || fieldValue === 'Select') {
                isValid = false;
                $(this).addClass('is-invalid');
                missingFields.push(fieldName);
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Step 2: Bio validation (min 100 chars)
        if (current === 2) {
            const bioField = currentFieldset.find('[name="bio"]');
            const bioValue = bioField.val() || '';
            if (bioValue.length < 100) {
                isValid = false;
                alert('Bio must be at least 100 characters. Current: ' + bioValue.length + ' characters');
                bioField.addClass('is-invalid').focus();
                return false;
            }
        }

        // Step 7: Skills validation
        if (current === 7) {
            if (tagify && tagify.value.length > 0) {
                const skillsString = tagify.value.map(item => item.value).join(',');
                $('#skills-input').val(skillsString);
            }
            
            if (tagify.value.length === 0) {
                isValid = false;
                alert('Please add at least one skill.');
                $('#skills-input').focus();
                return false;
            }
        }

        if (!isValid) {
            if (missingFields.length > 0) {
                alert('Please fill the following required fields:\n- ' + missingFields.join('\n- '));
            } else {
                alert('Please fill all required fields marked with *');
            }
            return false;
        }

        // Force update skills from Tagify before submit
        if (tagify && tagify.value.length > 0) {
            const skillsString = tagify.value.map(item => item.value).join(',');
            $('#skills-input').val(skillsString);
        }

        // Disable button and show loading
        saveButton.prop('disabled', true).val('Saving...');

        // Submit form via AJAX
        const formData = new FormData($('#msform')[0]);
        
        $.ajax({
            url: $('#msform').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Move to next tab
                current_fs = currentFieldset;
                next_fs = currentFieldset.next();
                
                if (next_fs.length) {
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                    next_fs.show();
                    current_fs.animate({opacity: 0}, {
                        step: function(now) {
                            current_fs.css({'display': 'none', 'position': 'relative'});
                            next_fs.css({'opacity': 1 - now});
                        },
                        duration: 500
                    });
                    setProgressBar(++current);
                }
                
                // Re-enable button
                saveButton.prop('disabled', false).val('Save & Continue');
            },
            error: function(xhr) {
                alert('Error saving data. Please try again.');
                saveButton.prop('disabled', false).val('Save & Continue');
            }
        });
    });

    function setProgressBar(curStep){
        var percent = (100 / steps) * curStep;
        $(".progress-bar").css("width", percent + "%");
        try { localStorage.setItem('cvCurrentStep', String(curStep - 1)); } catch(e) {}
    }

    // Make progress bar tabs clickable
    $('.clickable-step').on('click', function(e) {
        e.preventDefault();
        const targetStep = Number($(this).data('step'));
        const $fieldsets = $('#msform fieldset');
        const $targetFieldset = $fieldsets.eq(targetStep);

        if ($targetFieldset.length) {
            // Hide all fieldsets completely
            $fieldsets.each(function () {
                $(this).stop(true, true).css({ opacity: 1 }).hide();
            });

            // Show target fieldset explicitly
            $targetFieldset.stop(true, true).css({ opacity: 1, display: 'block' });

            // Update progress bar
            $("#progressbar li").removeClass("active");
            $("#progressbar li").each(function(index) {
                if (index <= targetStep) {
                    $(this).addClass("active");
                }
            });

            // Update current step and progress bar width
            current = targetStep + 1;
            setProgressBar(current);
        }
    });

    // Form submission handler
    $('#msform').on('submit', function(e) {
        console.log('=== FORM SUBMISSION ===');
        
        // CRITICAL: Force update input from Tagify BEFORE any validation
        if (tagify && tagify.value.length > 0) {
            const skillsString = tagify.value.map(item => item.value).join(',');
            input.value = skillsString;
            $('#skills-input').val(skillsString);
            console.log('✅ Force updated skills:', skillsString);
        }
        
        const skillsInputValue = $('#skills-input').val();
        const tagifyCount = tagify ? tagify.value.length : 0;
        
        console.log('Tagify count:', tagifyCount);
        console.log('Input value:', skillsInputValue);
        console.log('Tagify tags:', tagify ? tagify.value : 'null');
        
        // Validate using Tagify count (more reliable than input value)
        if (tagifyCount === 0) {
            e.preventDefault();
            console.error('❌ No skills found!');
            alert('ERROR: No skills detected!\n\nCurrent tags: ' + tagifyCount + '\n\nPlease:\n1. Go back to Step 7\n2. Add skills by pressing Enter\n3. Try again');
            return false;
        }

        // Check bio
        const bioValue = $('[name="bio"]').val();
        if (!bioValue || bioValue.length < 100) {
            e.preventDefault();
            alert('Bio must be at least 100 characters\nCurrent: ' + (bioValue ? bioValue.length : 0));
            return false;
        }

        console.log('✅ VALIDATION PASSED!');
        console.log('Submitting with skills:', skillsInputValue);
        
        // Show loading
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');
        
        return true;
    });

    // (Removed template selector logic)
});
*/
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let projectCount = {{ $projects->count() > 0 ? $projects->count() : 1 }};
let experienceCount = {{ $experiences->count() > 0 ? $experiences->count() : 1 }};
let educationCount = {{ $educations->count() > 0 ? $educations->count() : 1 }};
let certificateCount = {{ $certificates->count() > 0 ? $certificates->count() : 1 }};

const stepEndpoint = "{{ route('seeker.cv.step') }}";
const submitEndpoint = "{{ route('seeker.cv.submit') }}";
const stepOrder = ['basic', 'bio', 'projects', 'experience', 'education', 'certificates', 'skills', 'submit'];

let currentStepIndex = 0;
let maxVisitedStep = 0;
let cropper = null;
let cropperImage = null;
let validator = null;
let csrfToken = '';

$(document).ready(function () {
    initAjaxCsrf();
    initCropper();
    initTagify();
    initStepper();
});

function initAjaxCsrf() {
    const metaToken = $('meta[name="csrf-token"]').attr('content');
    const inputToken = $('input[name="_token"]').first().val();
    csrfToken = metaToken || inputToken || '';
    if (csrfToken) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
    }
}

function initStepper() {
    const $form = $('#msform');

    validator = $form.validate({
        ignore: ':hidden:not(.validate-hidden)',
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        highlight: function (element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if (element.closest('.form-check').length) {
                error.appendTo(element.closest('.form-check'));
            } else {
                error.insertAfter(element);
            }
        }
    });

    const storedIndex = parseInt(localStorage.getItem('cvCurrentStep'), 10);
    currentStepIndex = (!isNaN(storedIndex) && storedIndex >= 0 && storedIndex < stepOrder.length) ? storedIndex : 0;

    const storedMax = parseInt(localStorage.getItem('cvMaxStep'), 10);
    maxVisitedStep = (!isNaN(storedMax) && storedMax >= currentStepIndex) ? storedMax : currentStepIndex;

    $form.find('fieldset').hide();
    goToStep(currentStepIndex, { resetErrors: true });

    $('.save-step').on('click', function () {
        const $fieldset = $(this).closest('fieldset');
        handleStepSave($fieldset, { advance: false });
    });

    $('.next-step').on('click', function () {
        const $fieldset = $(this).closest('fieldset');
        handleStepSave($fieldset, { advance: true });
    });

    $('.previous').on('click', function () {
        goToStep(Math.max(0, currentStepIndex - 1));
    });

    $('.final-submit').on('click', function () {
        submitCv();
    });

    $('.clickable-step').on('click', function () {
        const targetIndex = parseInt($(this).data('step'), 10);
        if (isNaN(targetIndex)) {
            return;
        }

        if (targetIndex <= maxVisitedStep) {
            goToStep(targetIndex);
        } else {
            Swal.fire('Hold on', 'Please complete the previous steps before jumping ahead.', 'info');
        }
    });
}

function goToStep(index, options = {}) {
    if (index < 0 || index >= stepOrder.length) {
        return;
    }

    const $form = $('#msform');
    const $fieldsets = $form.find('fieldset');

    $fieldsets.hide();
    const $target = $fieldsets.eq(index);
    $target.show();

    currentStepIndex = index;
    if (currentStepIndex > maxVisitedStep) {
        maxVisitedStep = currentStepIndex;
    }

    localStorage.setItem('cvCurrentStep', currentStepIndex);
    localStorage.setItem('cvMaxStep', maxVisitedStep);

    $('#progressbar li').removeClass('active').each(function (idx) {
        if (idx <= currentStepIndex) {
            $(this).addClass('active');
        }
    });

    const progressPercent = ((currentStepIndex + 1) / stepOrder.length) * 100;
    $('.progress-bar').css('width', progressPercent + '%');

    if (validator && options.resetErrors !== false) {
        validator.resetForm();
        $form.find('.is-invalid').removeClass('is-invalid');
    }

    $('html, body').animate({
        scrollTop: $form.offset().top - 120
    }, 300);
}

function handleStepSave($fieldset, { advance }) {
    const stepKey = $fieldset.data('step');
    if (!stepKey || stepKey === 'submit') {
        return;
    }

    if (!validator.form()) {
        Swal.fire('Validation Required', 'Please fix the highlighted fields before continuing.', 'warning');
        return;
    }

    const $buttons = $fieldset.find('.save-step, .next-step');
    $buttons.prop('disabled', true);

    const request = saveStep(stepKey, $fieldset);

    request.done(function (response) {
        const message = response && response.message ? response.message : 'Step saved successfully.';

        if (advance) {
            const nextIndex = Math.min(stepOrder.length - 1, currentStepIndex + 1);
            goToStep(nextIndex);
            showToast(message);
        } else {
            showToast(message);
        }
    }).always(function () {
        $buttons.prop('disabled', false);
    });
}

function saveStep(stepKey, $fieldset) {
    const formData = collectStepFormData($fieldset);

    return $.ajax({
        url: stepEndpoint,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
    }).fail(function (xhr) {
        handleAjaxErrors(xhr);
    });
}

function collectStepFormData($fieldset) {
    const formData = new FormData();
    formData.append('step', $fieldset.data('step') || '');

    if (csrfToken) {
        formData.append('_token', csrfToken);
    }

    $fieldset.find(':input[name]').each(function () {
        const $input = $(this);
        if ($input.is(':disabled')) {
            return;
        }

        const name = $input.attr('name');
        if (!name) {
            return;
        }

        if ($input.attr('type') === 'file') {
            const files = this.files;
            if (files && files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    formData.append(name, files[i]);
                }
            }
            return;
        }

        if (($input.is(':checkbox') || $input.is(':radio')) && !$input.is(':checked')) {
            return;
        }

        formData.append(name, $input.val());
    });

    return formData;
}

function handleAjaxErrors(xhr) {
    let message = 'An unexpected error occurred. Please try again.';
    if (xhr && xhr.responseJSON) {
        const response = xhr.responseJSON;
        if (response.message) {
            message = response.message;
        }

        if (response.errors) {
            const formattedErrors = formatValidationErrors(response.errors);
            if (validator) {
                validator.showErrors(formattedErrors);
            }
        }
    }
    Swal.fire('Error', message, 'error');
}

function formatValidationErrors(errors) {
    const formatted = {};
    Object.keys(errors).forEach(function (key) {
        const messages = Array.isArray(errors[key]) ? errors[key][0] : errors[key];
        const fieldName = key.replace(/\.(\d+)\./g, '[$1][').replace(/\.(\d+)$/g, '[$1]');
        formatted[fieldName] = messages;
    });
    return formatted;
}

function showToast(message, icon = 'success') {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });

    Toast.fire({
        icon: icon,
        title: message
    });
}

function submitCv() {
    if (!csrfToken) {
        Swal.fire('Error', 'Missing CSRF token. Please refresh the page.', 'error');
        return;
    }

    const $button = $('.final-submit');
    $button.prop('disabled', true);

    Swal.fire({
        title: 'Submitting...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: submitEndpoint,
        method: 'POST',
        data: { _token: csrfToken }
    }).done(function (response) {
        Swal.fire({
            icon: 'success',
            title: 'Submitted',
            text: response && response.message ? response.message : 'Your CV has been submitted for approval.',
            confirmButtonText: response && response.redirect ? 'Open Preview' : 'OK'
        }).then(() => {
            if (response && response.redirect) {
                window.location.href = response.redirect;
            }
        });
    }).fail(function (xhr) {
        Swal.close();
        handleAjaxErrors(xhr);
    }).always(function () {
        $button.prop('disabled', false);
    });
}

function initTagify() {
    const input = document.getElementById('skills-input');
    if (!input) {
        return;
    }

    if (typeof Tagify === 'undefined') {
        Swal.fire('Error', 'Unable to load the skills component. Please refresh the page.', 'error');
        return;
    }

    const tagify = new Tagify(input, {
        originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(','),
        delimiters: ',|;',
        maxTags: 30,
        dropdown: {
            enabled: 0
        }
    });

    const syncInputValue = () => {
        input.value = tagify.value.map(item => item.value).join(',');
        const count = tagify.value.length;
        $('#skills-count').text(count);
        if (count > 0) {
            $('#skills-debug').show();
        } else {
            $('#skills-debug').hide();
        }
    };

    const initialSkills = input.value;
    if (initialSkills && initialSkills.trim() !== '') {
        tagify.addTags(initialSkills);
        syncInputValue();
    }

    tagify.on('add', syncInputValue);
    tagify.on('remove', syncInputValue);
}

function initCropper() {
    $('#profile_picture_input').on('change', function (e) {
        const file = e.target.files[0];
        if (!file) {
            return;
        }

        if (!file.type.match('image.*')) {
            Swal.fire('Invalid File', 'Please select a valid image file (JPG or PNG).', 'error');
            $(this).val('');
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            Swal.fire('File Too Large', 'Image size should be less than 2MB.', 'error');
            $(this).val('');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            if (cropper) {
                cropper.destroy();
            }
            if (cropperImage) {
                cropperImage.remove();
            }

            cropperImage = $('<img>').attr('id', 'cropper-image').attr('src', event.target.result);
            $('#cropper-preview').html(cropperImage);
            $('#image-cropper-container').show();

            cropper = new Cropper(cropperImage[0], {
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
                ready: function () {
                    updatePreview();
                }
            });

            let previewTimeout;
            cropperImage[0].addEventListener('crop', function () {
                clearTimeout(previewTimeout);
                previewTimeout = setTimeout(updatePreview, 100);
            });

            cropperImage[0].addEventListener('cropend', function () {
                updatePreview();
            });
        };
        reader.readAsDataURL(file);
    });

    $('#crop-btn').on('click', function () {
        if (!cropper) {
            return;
        }

        const canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high'
        });

        if (!canvas) {
            return;
        }

        canvas.toBlob(function (blob) {
            const file = new File([blob], 'profile_picture.jpg', { type: 'image/jpeg' });

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);

            const fileInput = document.getElementById('profile_picture');
            fileInput.files = dataTransfer.files;

            const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
            $('#cropped_image_data').val(dataUrl);

            const currentPreview = document.getElementById('current-profile-preview');
            if (currentPreview) {
                currentPreview.src = dataUrl;
                currentPreview.style.display = '';
            }

            $('#image-cropper-container').hide();
            showToast('Profile image updated successfully.');
        }, 'image/jpeg', 0.9);
    });

    $('#cancel-crop-btn').on('click', function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        if (cropperImage) {
            cropperImage.remove();
            cropperImage = null;
        }
        $('#image-cropper-container').hide();
        $('#profile_picture_input').val('');
        $('#profile_picture').val('');
        $('#cropped_image_data').val('');
        $('#cropped-preview-img').hide();
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

    if (!canvas) {
        return;
    }

    const previewImg = $('#cropped-preview-img');
    previewImg.attr('src', canvas.toDataURL('image/jpeg', 0.9));
    previewImg.show();
}

window.addProject = function () {
    const container = $('#projects-container');
    const html = `
        <div class="project-item mb-4 p-3 border rounded position-relative">
            <button type="button" class="btn btn-sm btn-danger remove-item-btn" onclick="$(this).parent().remove()">
                <i class="fas fa-times"></i>
            </button>
            <div class="row">
                <div class="col-lg-6">
                    <label class="fieldlabels">Project Name</label>
                    <input type="text" class="form-control" name="projects[${projectCount}][name]" placeholder="Project Name">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">Project Type</label>
                    <input type="text" class="form-control" name="projects[${projectCount}][type]" placeholder="Web App, Mobile App, etc.">
                </div>
                <div class="col-lg-12">
                    <label class="fieldlabels">Project Link</label>
                    <input type="url" class="form-control" name="projects[${projectCount}][link]" placeholder="https://example.com">
                </div>
                <div class="col-lg-12">
                    <label class="fieldlabels">Description</label>
                    <textarea class="form-control" name="projects[${projectCount}][description]" rows="2" placeholder="Brief description"></textarea>
                </div>
            </div>
        </div>
    `;
    container.append(html);
    projectCount++;
};

window.addExperience = function () {
    const container = $('#experience-container');
    const html = `
        <div class="experience-item mb-4 p-3 border rounded position-relative">
            <button type="button" class="btn btn-sm btn-danger remove-item-btn" onclick="$(this).parent().remove()">
                <i class="fas fa-times"></i>
            </button>
            <div class="row">
                <div class="col-lg-6">
                    <label class="fieldlabels">Company Name</label>
                    <input type="text" class="form-control" name="experience[${experienceCount}][company]" placeholder="Company Name">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">Job Title</label>
                    <input type="text" class="form-control" name="experience[${experienceCount}][title]" placeholder="Your Position">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">Start Date</label>
                    <input type="date" class="form-control" name="experience[${experienceCount}][start_date]">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">End Date</label>
                    <input type="date" class="form-control" name="experience[${experienceCount}][end_date]">
                </div>
                <div class="col-lg-12">
                    <label class="fieldlabels">Description</label>
                    <textarea class="form-control" name="experience[${experienceCount}][description]" rows="2" placeholder="Your responsibilities"></textarea>
                </div>
            </div>
        </div>
    `;
    container.append(html);
    experienceCount++;
};

window.addEducation = function () {
    const container = $('#education-container');
    const html = `
        <div class="education-item mb-4 p-3 border rounded position-relative">
            <button type="button" class="btn btn-sm btn-danger remove-item-btn" onclick="$(this).parent().remove()">
                <i class="fas fa-times"></i>
            </button>
            <div class="row">
                <div class="col-lg-6">
                    <label class="fieldlabels">Institution Name</label>
                    <input type="text" class="form-control" name="education[${educationCount}][institution]" placeholder="University/School">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">Degree</label>
                    <select class="form-control" name="education[${educationCount}][degree]">
                        <option value="">Select</option>
                        <option value="High School">High School</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Vocational">Vocational</option>
                        <option value="Bachelor's">Bachelor's</option>
                        <option value="Master's">Master's</option>
                        <option value="PhD">PhD</option>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">Field of Study</label>
                    <input type="text" class="form-control" name="education[${educationCount}][field]" placeholder="e.g., Computer Science">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">Graduation Year</label>
                    <input type="number" class="form-control" name="education[${educationCount}][year]" placeholder="e.g., 2020" min="1950" max="{{ date('Y') + 10 }}">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">Start Date</label>
                    <input type="date" class="form-control" name="education[${educationCount}][start_date]">
                </div>
                <div class="col-lg-6">
                    <label class="fieldlabels">End Date</label>
                    <input type="date" class="form-control" name="education[${educationCount}][end_date]">
                </div>
            </div>
        </div>
    `;
    container.append(html);
    educationCount++;
};

window.addCertificate = function () {
    const container = $('#certificates-container');
    const html = `
        <div class="certificate-item mb-4 p-3 border rounded position-relative">
            <button type="button" class="btn btn-sm btn-danger remove-item-btn" onclick="$(this).parent().remove()">
                <i class="fas fa-times"></i>
            </button>
            <div class="row">
                <div class="col-lg-12">
                    <label class="fieldlabels">Certificate Name</label>
                    <input type="text" class="form-control" name="certificates[${certificateCount}][name]" placeholder="Certificate Name">
                </div>
                <div class="col-lg-12">
                    <label class="fieldlabels">Issuing Organization</label>
                    <input type="text" class="form-control" name="certificates[${certificateCount}][organization]" placeholder="Organization Name">
                </div>
                <div class="col-lg-12">
                    <label class="fieldlabels">Issue Date</label>
                    <input type="date" class="form-control" name="certificates[${certificateCount}][date]">
                </div>
            </div>
        </div>
    `;
    container.append(html);
    certificateCount++;
};
</script>
@endpush
@endsection

