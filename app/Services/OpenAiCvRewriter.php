<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAiCvRewriter
{
    public function rewrite(array $parsed, ?string $targetRole = null): array
    {
        $key = config('services.openai.key');
        if (! $key) {
            throw new \RuntimeException('OPENAI_API_KEY is not configured.');
        }

        $model = config('services.openai.model', 'gpt-4o-mini');

        $system = "You are a senior recruiter who rewrites CVs so they pass ATS (Applicant Tracking System) parsers.\n"
            . "RULES:\n"
            . "- Use standard section names: Summary, Skills, Experience, Education, Languages.\n"
            . "- One column, no tables, no icons, no images.\n"
            . "- Use industry-standard keywords inferred from the candidate's experience and target role.\n"
            . "- Bullet points must start with strong action verbs and include quantified impact when possible.\n"
            . "- Keep the candidate's facts truthful — do not invent employers, dates, or qualifications.\n"
            . "- Return STRICT JSON conforming to the schema described in the user message.";

        $user = "Target role: " . ($targetRole ?: 'best fit based on experience') . "\n\n"
            . "Source CV data (extracted by parser):\n"
            . json_encode($parsed, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            . "\n\nReturn JSON with this exact shape:\n"
            . json_encode([
                'name' => 'string',
                'headline' => 'string (job title + years exp)',
                'contact' => ['email' => 'string|null', 'phone' => 'string|null', 'location' => 'string|null'],
                'summary' => 'string (3-4 sentences)',
                'skills' => ['array of strings, ordered most-relevant first'],
                'experience' => [[
                    'company' => 'string',
                    'title'   => 'string',
                    'start'   => 'string|null',
                    'end'     => 'string|null',
                    'bullets' => ['array of impact bullets'],
                ]],
                'education' => [[
                    'institution' => 'string',
                    'degree'      => 'string',
                    'start'       => 'string|null',
                    'end'         => 'string|null',
                ]],
                'languages' => ['array of strings'],
                'ats_score' => 'integer 0-100 (how ATS-ready this CV now is)',
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $response = Http::withToken($key)
            ->timeout(90)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'response_format' => ['type' => 'json_object'],
                'temperature' => 0.3,
                'messages' => [
                    ['role' => 'system', 'content' => $system],
                    ['role' => 'user',   'content' => $user],
                ],
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException('OpenAI rewrite failed: ' . $response->status() . ' ' . $response->body());
        }

        $content = $response->json('choices.0.message.content');
        $decoded = json_decode((string) $content, true);

        if (! is_array($decoded)) {
            throw new \RuntimeException('OpenAI returned non-JSON content.');
        }

        return $decoded;
    }
}
