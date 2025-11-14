<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>{{ ($profile->full_name ?? $user->name) }} CV</title>
</head>
<body style="font-family: Arial, sans-serif; color:#000; font-size:14px; line-height:1.6; margin:0; padding:0;">
<table width="700" align="center" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; background-color:#fff; padding:20px;">
  <tr>
    <td align="center" style="padding-bottom:10px;">
      <h2 style="margin:0; font-size:26px; letter-spacing:1px;">{{ strtoupper($profile->full_name ?? $user->name) }}</h2>
      <p style="margin:0; font-weight:bold; font-size:16px;">{{ strtoupper($profile->current_position ?? 'PROFESSIONAL') }}</p>
    </td>
  </tr>

  <tr>
    <td align="center" style="padding:5px 0; border-bottom:1px solid #000;">
      <p style="margin:0; font-size:13px;">
        @php
            $location = trim(($profile->city ?? '') . (($profile->city ?? null) && ($profile->country ?? null) ? ', ' : '') . ($profile->country ?? ''));
            $links = isset($profile->social_links) ? (is_array($profile->social_links) ? $profile->social_links : json_decode($profile->social_links, true)) : [];
            $links = is_array($links) ? $links : [];
            $candidateKeys = ['linkedin','github','twitter','website','facebook','instagram'];
            foreach ($candidateKeys as $k) {
                if (empty($links[$k]) && !empty($profile->$k)) {
                    $links[$k] = $profile->$k;
                }
            }
            // Show contact details only if explicitly allowed (for admins/employers or the seeker themselves)
            $showContactDetails = $showContactDetails ?? false;
        @endphp
        {{ $location ?: '' }}{!! $location && $showContactDetails ? ' | ' : ($location ? '' : '') !!}
        @if($showContactDetails)
        Email: <a href="mailto:{{ $user->email }}" style="color:#000;">{{ $user->email }}</a> |
        Contact# {{ $user->phone ?? 'N/A' }}
        @endif
      </p>
    </td>
  </tr>

  @if(!empty($profile->bio))
  <tr>
    <td style="padding:15px 0;">
      <p style="margin:0;">
        {{ $profile->bio }}
      </p>
    </td>
  </tr>
  @endif

  @php
    $skills = is_array($profile->skills ?? null) ? $profile->skills : (isset($profile->skills) && is_string($profile->skills) ? json_decode($profile->skills, true) : []);
    $skills = is_array($skills) ? array_values(array_filter($skills)) : [];
    $half = ceil(count($skills) / 2);
    $skillsCol1 = array_slice($skills, 0, $half);
    $skillsCol2 = array_slice($skills, $half);
  @endphp
  @if(count($skills) > 0)
  <tr>
    <td style="padding-top:10px;">
      <h3 style="border-top:1px solid #000; border-bottom:1px solid #000; padding:5px 0; margin:0; font-size:16px;">AREA OF EXPERTISE</h3>
      <table width="100%" cellpadding="4" cellspacing="0" style="margin-top:5px;">
        <tr>
          <td width="50%" valign="top">
            <ul style="margin:0; padding-left:18px;">
              @foreach($skillsCol1 as $skill)
                <li>{{ $skill }}</li>
              @endforeach
            </ul>
          </td>
          <td width="50%" valign="top">
            <ul style="margin:0; padding-left:18px;">
              @foreach($skillsCol2 as $skill)
                <li>{{ $skill }}</li>
              @endforeach
            </ul>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  @endif

  @if($experiences->count() > 0)
  <tr>
    <td style="padding-top:15px;">
      <h3 style="border-top:1px solid #000; border-bottom:1px solid #000; padding:5px 0; margin:0; font-size:16px;">PROFESSIONAL EXPERIENCE</h3>
      @foreach($experiences as $exp)
        <p style="margin:8px 0 0 0; font-weight:bold;">
          {{ $exp->company_name }} – {{ $exp->job_title }}
          <span style="float:right;">
            {{ $exp->start_date ? $exp->start_date->format('M Y') : '' }} – {{ $exp->end_date ? $exp->end_date->format('M Y') : 'Present' }}
          </span>
        </p>
        @if($exp->description)
        <ul style="margin:5px 0 10px 20px; padding:0;">
          @foreach(preg_split('/\r\n|\r|\n/', $exp->description) as $line)
            @if(trim($line) !== '')
              <li>{{ $line }}</li>
            @endif
          @endforeach
        </ul>
        @endif
      @endforeach
    </td>
  </tr>
  @endif

  @if($educations->count() > 0)
  <tr>
    <td style="padding-top:15px;">
      <h3 style="border-top:1px solid #000; border-bottom:1px solid #000; padding:5px 0; margin:0; font-size:16px;">EDUCATION</h3>
      @foreach($educations as $edu)
        <p style="margin:8px 0 0 0; font-weight:bold;">
          {{ $edu->degree }}{{ $edu->field_of_study ? ' - ' . $edu->field_of_study : '' }}
          <span style="float:right;">
            {{ $edu->start_date ? $edu->start_date->format('M Y') : '' }}{{ $edu->start_date || $edu->end_date ? ' - ' : '' }}{{ $edu->end_date ? $edu->end_date->format('M Y') : 'In Progress' }}
          </span>
        </p>
        <p style="margin:0 0 8px 0;">
          {{ $edu->institution_name }}
        </p>
      @endforeach
    </td>
  </tr>
  @endif

  @if($certificates->count() > 0)
  <tr>
    <td style="padding-top:15px;">
      <h3 style="border-top:1px solid #000; border-bottom:1px solid #000; padding:5px 0; margin:0; font-size:16px;">VOCATIONAL QUALIFICATION</h3>
      @foreach($certificates as $cert)
        <p style="margin:8px 0 0 0; font-weight:bold;">
          {{ $cert->certificate_name }}
          <span style="float:right;">{{ $cert->issue_date ? $cert->issue_date->format('M Y') : '' }}</span>
        </p>
        <p style="margin:0;">
          {{ $cert->issuing_organization }}
        </p>
      @endforeach
    </td>
  </tr>
  @endif

  <tr>
    <td style="padding-top:15px;">
      <h3 style="border-top:1px solid #000; border-bottom:1px solid #000; padding:5px 0; margin:0; font-size:16px;">ADDITIONAL INFORMATION</h3>
      <ul style="margin:8px 0 0 18px; padding:0;">
        @if(!empty($profile->nationality))
          <li>Nationality: {{ $profile->nationality }}</li>
        @endif
        @php
            $langs = is_array($profile->languages ?? null) ? $profile->languages : (isset($profile->languages) && is_string($profile->languages) ? json_decode($profile->languages, true) : []);
            $langs = is_array($langs) ? array_values(array_filter($langs)) : [];
        @endphp
        @if(count($langs) > 0)
          <li>Languages: {{ implode(' & ', $langs) }}</li>
        @endif
        @if(!empty($profile->date_of_birth))
          <li>Date of Birth: {{ $profile->date_of_birth->format('d M, Y') }}</li>
        @endif
        @if(!empty($profile->gender))
          <li>Gender: {{ ucfirst($profile->gender) }}</li>
        @endif
      </ul>
    </td>
  </tr>
</table>
</body>
</html>


