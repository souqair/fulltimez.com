<?php

namespace App\Http\Middleware;

use App\Services\CountryContext;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DetectCountrySubdomain
{
    public function __construct(protected CountryContext $context) {}

    public function handle(Request $request, Closure $next)
    {
        $country = $this->context->resolveFromRequest($request);

        $request->attributes->set('country', $country);

        View::share('currentCountry', $country);
        View::share('availableCountries', $this->context->all());

        return $next($request);
    }
}
