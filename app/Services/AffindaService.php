<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class AffindaService
{
    protected string $base = 'https://api.affinda.com/v3';

    public function parseResume(string $absolutePath): array
    {
        $key = config('services.affinda.key');
        if (! $key) {
            throw new \RuntimeException('AFFINDA_API_KEY is not configured.');
        }

        $workspace = config('services.affinda.workspace');

        $response = Http::withToken($key)
            ->timeout(60)
            ->attach('file', file_get_contents($absolutePath), basename($absolutePath))
            ->post($this->base . '/documents', array_filter([
                'wait' => 'true',
                'workspace' => $workspace,
            ]));

        if (! $response->successful()) {
            throw new \RuntimeException('Affinda parse failed: ' . $response->status() . ' ' . $response->body());
        }

        $data = $response->json('data', []);

        return [
            'name'        => $data['name']['raw'] ?? null,
            'email'       => $data['emails'][0] ?? null,
            'phone'       => $data['phoneNumbers'][0] ?? null,
            'location'    => $data['location']['formatted'] ?? null,
            'summary'     => $data['summary'] ?? $data['objective'] ?? null,
            'skills'      => collect($data['skills'] ?? [])->pluck('name')->filter()->values()->all(),
            'languages'   => collect($data['languages'] ?? [])->pluck('name')->filter()->values()->all(),
            'education'   => array_map(fn ($e) => [
                'institution' => $e['organization'] ?? null,
                'degree'      => $e['accreditation']['inputStr'] ?? ($e['accreditation']['education'] ?? null),
                'start'       => $e['dates']['startDate'] ?? null,
                'end'         => $e['dates']['completionDate'] ?? null,
            ], $data['education'] ?? []),
            'experience'  => array_map(fn ($w) => [
                'company'     => $w['organization'] ?? null,
                'title'       => $w['jobTitle']['name'] ?? ($w['jobTitle'] ?? null),
                'start'       => $w['dates']['startDate'] ?? null,
                'end'         => $w['dates']['endDate'] ?? null,
                'description' => $w['jobDescription'] ?? null,
            ], $data['workExperience'] ?? []),
            'raw_text'    => $data['rawText'] ?? null,
        ];
    }
}
