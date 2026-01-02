<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $profile->full_name ?? $user->name }} - Resume</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 32px;
            background-color: #fdfdfd;
        }
        .resume-container {
            max-width: 780px;
            margin: 0 auto;
            background: #ffffff;
        }
        .header {
            border-bottom: 3px solid #673AB7;
            padding-bottom: 20px;
            margin-bottom: 28px;
            text-align: center;
        }
        .header .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 14px;
            border: 4px solid #673AB7;
        }
        .header .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .header h1 {
            font-size: 32px;
            color: #673AB7;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .header .position {
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #666;
            margin-bottom: 10px;
        }
        .header .contact {
            font-size: 11px;
            color: #777;
            line-height: 1.4;
        }
        .section {
            margin-bottom: 26px;
            page-break-inside: avoid;
        }
        .section h2 {
            font-size: 15px;
            color: #673AB7;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-bottom: 6px;
            border-bottom: 2px solid #673AB7;
            margin-bottom: 14px;
        }
        .summary {
            text-align: justify;
        }
        .info-grid {
            display: flex;
            flex-wrap: wrap;
        }
        .info-item {
            width: 50%;
            margin-bottom: 8px;
            font-size: 12px;
        }
        .info-label {
            font-weight: bold;
            color: #444;
        }
        .badge-list {
            margin-top: 6px;
        }
        .badge {
            display: inline-block;
            background-color: #673AB7;
            color: #fff;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 11px;
            margin: 3px;
        }
        .list-inline {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .list-inline li {
            display: inline-block;
            margin-right: 12px;
            margin-bottom: 6px;
            font-size: 11px;
            color: #555;
        }
        .timeline-item {
            margin-bottom: 18px;
            border-bottom: 1px solid #e7e7e7;
            padding-bottom: 12px;
        }
        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 6px;
        }
        .timeline-title {
            font-weight: bold;
            font-size: 13px;
            color: #333;
        }
        .timeline-subtitle {
            font-size: 12px;
            color: #666;
            font-style: italic;
        }
        .timeline-date {
            font-size: 11px;
            color: #5b5b5b;
            background-color: #f0f0ff;
            padding: 4px 8px;
            border-radius: 8px;
            margin-left: 10px;
        }
        .timeline-description {
            font-size: 11px;
            color: #545454;
            text-align: justify;
        }
        .footer {
            margin-top: 30px;
            padding-top: 16px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    @php
        $showContactDetails = $showContactDetails ?? true;
        $rawLinks = isset($profile->social_links) ? (is_array($profile->social_links) ? $profile->social_links : json_decode($profile->social_links, true)) : [];
        $rawLinks = is_array($rawLinks) ? $rawLinks : [];
        $candidateKeys = ['linkedin','github','twitter','website','facebook','instagram'];
        foreach ($candidateKeys as $k) {
            if (empty($rawLinks[$k]) && !empty($profile->$k)) {
                $rawLinks[$k] = $profile->$k;
            }
        }
        $links = array_filter($rawLinks);

        $skills = $profile->skills ?? [];
        if (is_string($skills)) {
            $decodedSkills = json_decode($skills, true);
            $skills = is_array($decodedSkills) ? $decodedSkills : [];
        }
        $skills = array_values(array_filter(is_array($skills) ? $skills : []));

        $languages = $profile->languages ?? [];
        if (is_string($languages)) {
            $decodedLangs = json_decode($languages, true);
            $languages = is_array($decodedLangs) ? $decodedLangs : [];
        }
        $languages = array_values(array_filter(is_array($languages) ? $languages : []));

        $profileImageSrc = null;
        if ($profile && $profile->profile_picture) {
            $imagePath = $profile->profile_picture;
            if (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://'])) {
                $profileImageSrc = $imagePath;
            } else {
                $cleanPath = ltrim($imagePath, '/');
                $fullPath = public_path($cleanPath);

                if (!file_exists($fullPath) && \Illuminate\Support\Str::startsWith($cleanPath, 'storage/')) {
                    $fullPath = public_path($cleanPath);
                }

                if (!file_exists($fullPath)) {
                    $storageRelative = preg_replace('#^storage/#', '', $cleanPath);
                    $fullPath = public_path('storage/' . $storageRelative);
                }

                if (file_exists($fullPath)) {
                    $type = pathinfo($fullPath, PATHINFO_EXTENSION) ?: 'png';
                    $data = base64_encode(file_get_contents($fullPath));
                    $profileImageSrc = 'data:image/' . $type . ';base64,' . $data;
                }
            }
        }
    @endphp

    <div class="resume-container">
        <div class="header">
            @if($profileImageSrc)
                <div class="avatar">
                    <img src="{{ $profileImageSrc }}" alt="Profile Photo">
                </div>
            @endif
            <h1>{{ strtoupper($profile->full_name ?? $user->name) }}</h1>
            <div class="position">{{ strtoupper($profile->current_position ?? 'Professional') }}</div>
            <div class="contact">
                Email: {{ $user->email }} | Phone: {{ $user->phone ?? 'N/A' }}<br>
                @php
                    $location = trim(($profile->city ?? '') . (($profile->city ?? null) && ($profile->country ?? null) ? ', ' : '') . ($profile->country ?? ''));
                @endphp
                @if($location)
                    Location: {{ $location }}<br>
                @endif
                @if(!empty($links))
                    @foreach($links as $label => $url)
                        {{ ucfirst($label) }}: {{ $url }}@if(!$loop->last) | @endif
                    @endforeach
                @endif
            </div>
        </div>

        @if($profile && $profile->bio)
            <div class="section">
                <h2>Professional Summary</h2>
                <div class="summary">{{ $profile->bio }}</div>
            </div>
        @endif

        <div class="section">
            <h2>Personal Information</h2>
            <div class="info-grid">
                @if($profile->nationality)
                    <div class="info-item"><span class="info-label">Nationality:</span> {{ $profile->nationality }}</div>
                @endif
                @if($profile->date_of_birth)
                    <div class="info-item"><span class="info-label">Date of Birth:</span> {{ $profile->date_of_birth->format('F d, Y') }}</div>
                @endif
                @if($profile->gender)
                    <div class="info-item"><span class="info-label">Gender:</span> {{ ucfirst($profile->gender) }}</div>
                @endif
                @if($profile->experience_years)
                    <div class="info-item"><span class="info-label">Experience:</span> {{ $profile->experience_years }}</div>
                @endif
                @if($profile->expected_salary)
                    <div class="info-item"><span class="info-label">Expected Salary:</span> {{ $profile->expected_salary }} AED</div>
                @endif
            </div>
        </div>

        @if(!empty($languages))
            <div class="section">
                <h2>Languages</h2>
                <div class="badge-list">
                    @foreach($languages as $language)
                        <span class="badge" style="background-color:#444;">{{ $language }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        @if(!empty($skills))
            <div class="section">
                <h2>Skills</h2>
                <div class="badge-list">
                    @foreach($skills as $skill)
                        <span class="badge">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        @if($experiences->count() > 0)
            <div class="section">
                <h2>Work Experience</h2>
                @foreach($experiences as $exp)
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <div>
                                <div class="timeline-title">{{ $exp->job_title }}</div>
                                <div class="timeline-subtitle">{{ $exp->company_name }}</div>
                            </div>
                            <div class="timeline-date">
                                {{ $exp->start_date ? $exp->start_date->format('M Y') : 'N/A' }} - {{ $exp->end_date ? $exp->end_date->format('M Y') : 'Present' }}
                            </div>
                        </div>
                        @if($exp->description)
                            <div class="timeline-description">{{ $exp->description }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if($projects->count() > 0)
            <div class="section">
                <h2>Projects</h2>
                @foreach($projects as $project)
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <div>
                                <div class="timeline-title">{{ $project->project_name }}</div>
                                @if($project->project_type)
                                    <div class="timeline-subtitle">{{ $project->project_type }}</div>
                                @endif
                            </div>
                            @if($project->project_link)
                                <div class="timeline-date" style="background-color:#e9e9ff; color:#333;">{{ $project->project_link }}</div>
                            @endif
                        </div>
                        @if($project->description)
                            <div class="timeline-description">{{ $project->description }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if($educations->count() > 0)
            <div class="section">
                <h2>Education</h2>
                @foreach($educations as $edu)
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <div>
                                <div class="timeline-title">{{ $edu->degree }}{{ $edu->field_of_study ? ' in ' . $edu->field_of_study : '' }}</div>
                                <div class="timeline-subtitle">{{ $edu->institution_name }}</div>
                            </div>
                            <div class="timeline-date">
                                {{ $edu->start_date ? $edu->start_date->format('Y') : '' }}{{ $edu->start_date || $edu->end_date ? ' - ' : '' }}{{ $edu->end_date ? $edu->end_date->format('Y') : 'In Progress' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($certificates->count() > 0)
            <div class="section">
                <h2>Certifications</h2>
                @foreach($certificates as $cert)
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <div>
                                <div class="timeline-title">{{ $cert->certificate_name }}</div>
                                <div class="timeline-subtitle">{{ $cert->issuing_organization }}</div>
                            </div>
                            <div class="timeline-date">
                                {{ $cert->issue_date ? $cert->issue_date->format('M Y') : '' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="footer">
            Generated via FullTimez - {{ now()->format('F d, Y') }}
        </div>
    </div>
</body>
</html>



