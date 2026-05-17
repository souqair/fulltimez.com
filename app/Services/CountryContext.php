<?php

namespace App\Services;

use Illuminate\Http\Request;

class CountryContext
{
    protected ?array $current = null;

    public function resolveFromRequest(Request $request): array
    {
        $host = strtolower($request->getHost());
        $subdomain = $this->extractSubdomain($host);

        $countries = config('countries.countries', []);
        $defaultKey = config('countries.default', 'global');

        $resolved = null;

        if ($subdomain) {
            foreach ($countries as $key => $country) {
                if (! empty($country['subdomain']) && strtolower($country['subdomain']) === $subdomain) {
                    $resolved = array_merge($country, ['key' => $key]);
                    break;
                }
            }
        }

        if (! $resolved) {
            $default = $countries[$defaultKey] ?? null;
            $resolved = $default ? array_merge($default, ['key' => $defaultKey]) : [
                'key' => 'global',
                'label' => 'Global',
                'name' => null,
                'code' => null,
                'subdomain' => null,
                'currency' => null,
                'flag' => null,
                'is_default' => true,
            ];
        }

        $this->current = $resolved;

        return $resolved;
    }

    public function current(): ?array
    {
        return $this->current;
    }

    public function name(): ?string
    {
        return $this->current['name'] ?? null;
    }

    public function code(): ?string
    {
        return $this->current['code'] ?? null;
    }

    public function key(): ?string
    {
        return $this->current['key'] ?? null;
    }

    public function isGlobal(): bool
    {
        return empty($this->current['name']);
    }

    public function aliases(): array
    {
        $aliases = $this->current['aliases'] ?? [];
        if (! empty($this->current['name']) && ! in_array($this->current['name'], $aliases, true)) {
            $aliases[] = $this->current['name'];
        }
        return $aliases;
    }

    public function all(): array
    {
        $countries = config('countries.countries', []);
        $list = [];
        foreach ($countries as $key => $country) {
            $list[] = array_merge($country, ['key' => $key]);
        }
        return $list;
    }

    protected function extractSubdomain(string $host): ?string
    {
        $host = preg_replace('/:\d+$/', '', $host);

        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return null;
        }

        $parts = explode('.', $host);

        if (count($parts) < 3) {
            return null;
        }

        $subdomain = strtolower($parts[0]);

        if (in_array($subdomain, ['www', 'admin', 'api'], true)) {
            return null;
        }

        return $subdomain;
    }
}
