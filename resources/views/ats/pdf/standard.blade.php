<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>{{ $cv['name'] ?? 'CV' }}</title>
<style>
    @page { margin: 32px 38px; }
    body { font-family: DejaVu Sans, Arial, sans-serif; color: #1a1a1a; font-size: 11pt; line-height: 1.5; }
    h1 { margin: 0 0 4px; font-size: 22pt; }
    .headline { color: #444; font-size: 11.5pt; margin-bottom: 8px; }
    .contact { color: #444; font-size: 10pt; margin-bottom: 18px; }
    h2 { font-size: 12pt; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #1a1a1a; padding-bottom: 4px; margin: 18px 0 8px; }
    .item-title { font-weight: bold; }
    .item-meta { color: #555; font-size: 10pt; margin-bottom: 4px; }
    ul { margin: 4px 0 10px 18px; padding: 0; }
    li { margin-bottom: 2px; }
    .skills span { display: inline-block; padding: 2px 0; margin-right: 14px; }
</style>
</head>
<body>

<h1>{{ $cv['name'] ?? '' }}</h1>
@if(!empty($cv['headline']))
    <div class="headline">{{ $cv['headline'] }}</div>
@endif

<div class="contact">
    @foreach(array_filter([
        $cv['contact']['email'] ?? null,
        $cv['contact']['phone'] ?? null,
        $cv['contact']['location'] ?? null,
    ]) as $i => $item)
        @if($i > 0) &nbsp;·&nbsp; @endif {{ $item }}
    @endforeach
</div>

@if(!empty($cv['summary']))
    <h2>Summary</h2>
    <div>{{ $cv['summary'] }}</div>
@endif

@if(!empty($cv['skills']) && is_array($cv['skills']))
    <h2>Skills</h2>
    <div class="skills">
        @foreach($cv['skills'] as $skill)
            <span>{{ $skill }}</span>
        @endforeach
    </div>
@endif

@if(!empty($cv['experience']) && is_array($cv['experience']))
    <h2>Experience</h2>
    @foreach($cv['experience'] as $exp)
        <div class="item-title">{{ $exp['title'] ?? '' }}@if(!empty($exp['company'])), {{ $exp['company'] }}@endif</div>
        <div class="item-meta">{{ trim(($exp['start'] ?? '') . ' – ' . ($exp['end'] ?? 'Present')) }}</div>
        @if(!empty($exp['bullets']) && is_array($exp['bullets']))
            <ul>
                @foreach($exp['bullets'] as $bullet)
                    <li>{{ $bullet }}</li>
                @endforeach
            </ul>
        @endif
    @endforeach
@endif

@if(!empty($cv['education']) && is_array($cv['education']))
    <h2>Education</h2>
    @foreach($cv['education'] as $edu)
        <div class="item-title">{{ $edu['degree'] ?? '' }}@if(!empty($edu['institution'])) — {{ $edu['institution'] }}@endif</div>
        <div class="item-meta">{{ trim(($edu['start'] ?? '') . ' – ' . ($edu['end'] ?? '')) }}</div>
    @endforeach
@endif

@if(!empty($cv['languages']) && is_array($cv['languages']))
    <h2>Languages</h2>
    <div>{{ implode(' · ', $cv['languages']) }}</div>
@endif

</body>
</html>
