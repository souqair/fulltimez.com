<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeoLocator
{
    /**
     * Resolve the visitor's ISO 3166 alpha-2 country code (lowercase),
     * e.g. "pk", "ae", "sa". Returns null when we cannot determine it.
     */
    public function countryCode(Request $request): ?string
    {
        // 1. If the site is behind Cloudflare, trust its header.
        $cf = $request->header('CF-IPCountry');
        if ($cf && strtoupper($cf) !== 'XX' && strtoupper($cf) !== 'T1') {
            return strtolower($cf);
        }

        $ip = $request->ip();

        if (! $ip || $this->isPrivateIp($ip)) {
            return null;
        }

        $cacheKey = "geo:country:{$ip}";
        $cached = Cache::get($cacheKey);
        if ($cached) {
            return $cached;
        }

        $code = $this->lookup($ip);
        if ($code) {
            Cache::put($cacheKey, $code, now()->addHours(24));
        }

        return $code;
    }

    protected function lookup(string $ip): ?string
    {
        try {
            $response = Http::timeout(2)
                ->retry(1, 200)
                ->get("https://ipapi.co/{$ip}/country/");

            if ($response->successful()) {
                $code = trim($response->body());
                if (preg_match('/^[A-Z]{2}$/', $code)) {
                    return strtolower($code);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('GeoLocator lookup failed', ['ip' => $ip, 'error' => $e->getMessage()]);
        }

        return null;
    }

    protected function isPrivateIp(string $ip): bool
    {
        if (! filter_var($ip, FILTER_VALIDATE_IP)) {
            return true;
        }

        return ! filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );
    }
}
