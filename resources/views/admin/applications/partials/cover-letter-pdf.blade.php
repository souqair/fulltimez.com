<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cover Letter - {{ $candidateName }}</title>
	<style>
		body { font-family: DejaVu Sans, sans-serif; color:#000; font-size: 12px; line-height: 1.6; }
		.header { text-align: center; margin-bottom: 20px; }
		.header h2 { margin: 0 0 6px 0; }
		.meta { color:#555; font-size: 12px; text-align: center; margin-bottom: 16px; }
		.content { white-space: pre-wrap; }
	</style>
</head>
<body>
	<div class="header">
		<h2>Cover Letter</h2>
		<div class="meta">
			<strong>Candidate:</strong> {{ $candidateName }}<br>
			<strong>Job:</strong> {{ $jobTitle }}
		</div>
	</div>
	<div class="content">
		{{ $application->cover_letter }}
	</div>
</body>
</html>


