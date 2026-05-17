# Country Subdomain Setup

This project supports filtering jobs and job-seekers by country based on the
subdomain that the visitor is using.

| Subdomain               | Country               |
| ----------------------- | --------------------- |
| `fulltimez.com`         | Global (no filter)    |
| `pk.fulltimez.com`      | Pakistan              |
| `ae.fulltimez.com`      | United Arab Emirates  |
| `sa.fulltimez.com`      | Saudi Arabia          |

All four subdomains run from the **same Laravel codebase**. There is no need to
deploy or configure separate projects.

## How it works

1. Every web request goes through `App\Http\Middleware\DetectCountrySubdomain`.
2. The middleware reads the `Host` header, extracts the first label
   (e.g. `pk` from `pk.fulltimez.com`) and matches it against
   [`config/countries.json`](config/countries.json).
3. The resolved country is stored in `App\Services\CountryContext` (singleton)
   and shared with all views as `$currentCountry` and `$availableCountries`.
4. The `HomeController`, `JobController` and `CandidateController` inject
   `CountryContext` and add a `whereIn('location_country', ...)` /
   `whereIn('country', ...)` clause when a country is active. On the bare
   domain (no subdomain) no filter is applied — global view.

## Geo-IP auto redirect

When a visitor lands on the bare domain (`fulltimez.com`), the middleware
attempts to redirect them to the subdomain that matches their country:

1. If the request is behind Cloudflare, the `CF-IPCountry` header is trusted.
2. Otherwise the visitor IP is looked up via `https://ipapi.co/{ip}/country/`.
3. The lookup is cached for 24 hours per IP (`Cache::remember`).
4. The resolved 2-letter code is matched against the `subdomain` field in
   `countries.json`. If a match exists, the visitor is `302`-redirected to
   `<subdomain>.fulltimez.com` with the same path/query.

The middleware skips the redirect when:

- Request is **not** a `GET`, or is AJAX / `Accept: application/json`.
- Host is `localhost` or an IP address.
- User agent looks like a known bot (Googlebot, Bingbot, FB scraper, etc.).
- Path begins with one of `api/`, `admin/`, `storage/`, `files/`, `email/`,
  `_debugbar`, `login`, `logout`, `jobseeker/`, `employer/`.
- Visitor has the `stay_global=1` cookie, or the URL contains `?global=1`.
  (Visiting `https://fulltimez.com/?global=1` sets the cookie and keeps the
  user on the global site permanently for 30 days.)

After a successful redirect, a `country_subdomain` cookie is set (30 days)
recording which subdomain they were sent to — useful for debugging.

## Adding a new country

Edit [`config/countries.json`](config/countries.json) and add a new entry under
`countries`:

```json
"qa": {
    "label": "Qatar",
    "name": "Qatar",
    "code": "QAT",
    "subdomain": "qa",
    "currency": "QAR",
    "flag": "qa",
    "aliases": ["Qatar"]
}
```

Field reference:

| Field        | Purpose                                                                       |
| ------------ | ----------------------------------------------------------------------------- |
| `label`      | Human-readable label shown in UI                                              |
| `name`       | Must match the country **name** stored in `countries.name` in the DB          |
| `code`       | 3-letter ISO code (used for display / future API)                             |
| `subdomain`  | The subdomain label, e.g. `qa` for `qa.fulltimez.com`                         |
| `currency`   | Optional ISO currency code                                                    |
| `flag`       | Optional 2-letter flag identifier                                             |
| `aliases`    | Extra spellings used in legacy data (`location_country`, `seeker_profiles.country`) — matched with `whereIn` |

Then point the DNS record for `qa.fulltimez.com` (CNAME or A) at the same
server, and add it to the web server's vhost (`ServerAlias qa.fulltimez.com`
for Apache, or include it in `server_name` for Nginx). No code changes
required.

If you're using `php artisan config:cache`, re-run it after editing the JSON
file.

## Local testing

For local development, edit `/etc/hosts`:

```
127.0.0.1   pk.fulltimez.test
127.0.0.1   ae.fulltimez.test
127.0.0.1   sa.fulltimez.test
127.0.0.1   fulltimez.test
```

Visit each host to confirm jobs and seekers are filtered.
