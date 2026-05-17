<?php

namespace App\Http\Middleware;

use App\Services\CountryContext;
use App\Services\GeoLocator;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DetectCountrySubdomain
{
    public function __construct(
        protected CountryContext $context,
        protected GeoLocator $geo,
    ) {}

    public function handle(Request $request, Closure $next)
    {
        $country = $this->context->resolveFromRequest($request);

        // If the visitor landed on the bare/global domain, try to geo-redirect
        // them to the subdomain that matches their country.
        if ($this->context->isGlobal() && $this->shouldAutoRedirect($request)) {
            $code = $this->geo->countryCode($request);
            $target = $this->resolveSubdomainForCode($code);

            if ($target) {
                $cookie = cookie('country_subdomain', $target, 60 * 24 * 30); // 30 days
                return redirect()
                    ->to($this->buildSubdomainUrl($request, $target), 302)
                    ->withCookie($cookie);
            }
        }

        // If user previously chose "stay global" or has a remembered country
        // cookie but is currently on global, only act on the chooser hint.
        if ($request->boolean('global')) {
            cookie()->queue(cookie('stay_global', '1', 60 * 24 * 30));
        }

        $request->attributes->set('country', $country);

        View::share('currentCountry', $country);
        View::share('availableCountries', $this->context->all());

        return $next($request);
    }

    protected function shouldAutoRedirect(Request $request): bool
    {
        if (! $request->isMethod('GET')) {
            return false;
        }

        if ($request->ajax() || $request->wantsJson()) {
            return false;
        }

        if ($request->boolean('global') || $request->cookie('stay_global')) {
            return false;
        }

        $host = $request->getHost();
        if (filter_var($host, FILTER_VALIDATE_IP) || $host === 'localhost') {
            return false;
        }

        $ua = strtolower((string) $request->userAgent());
        $botSignatures = ['bot', 'crawl', 'spider', 'slurp', 'bingpreview', 'facebookexternalhit', 'embedly', 'pingdom', 'uptimerobot'];
        foreach ($botSignatures as $signature) {
            if ($ua && str_contains($ua, $signature)) {
                return false;
            }
        }

        // Skip framework/system paths so we don't redirect signed URLs,
        // API endpoints, admin pages, file streams, etc.
        $skipPrefixes = ['api/', 'admin/', 'storage/', 'files/', 'email/', 'login', 'logout', 'jobseeker/', 'employer/', '_debugbar', 'up', 'storage-link'];
        $path = ltrim($request->path(), '/');
        foreach ($skipPrefixes as $prefix) {
            if ($path === rtrim($prefix, '/') || str_starts_with($path, $prefix)) {
                return false;
            }
        }

        return true;
    }

    protected function resolveSubdomainForCode(?string $code): ?string
    {
        if (! $code) {
            return null;
        }

        foreach (config('countries.countries', []) as $key => $country) {
            if (empty($country['subdomain'])) {
                continue;
            }
            if (strtolower($country['subdomain']) === strtolower($code)) {
                return strtolower($country['subdomain']);
            }
        }

        return null;
    }

    protected function buildSubdomainUrl(Request $request, string $subdomain): string
    {
        $host = $request->getHost();
        $port = $request->getPort();
        $scheme = $request->getScheme();

        // Strip any existing leading label that looks like a subdomain
        // (only when host has 3+ parts), so we can prepend the new one.
        $parts = explode('.', $host);
        if (count($parts) >= 3) {
            $apex = implode('.', array_slice($parts, 1));
        } else {
            $apex = $host;
        }

        $newHost = $subdomain . '.' . $apex;

        $url = $scheme . '://' . $newHost;
        if (($scheme === 'http' && $port && $port !== 80) || ($scheme === 'https' && $port && $port !== 443)) {
            $url .= ':' . $port;
        }
        $url .= $request->getRequestUri();

        return $url;
    }
}
