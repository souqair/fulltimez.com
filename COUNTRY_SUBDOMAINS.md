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
