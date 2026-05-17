# FullTimez SaaS — Setup & Deploy

This adds a country-aware pricing/checkout flow for jobseekers (Stripe
subscriptions + per-CV ATS generation) and a Filament admin panel at `/saas`.

## What was built

| Layer | Files |
|---|---|
| **Migrations** (Phase 1) | `database/migrations/2026_05_17_000001..000008_*.php` |
| **Models** | `app/Models/{Plan,VatRate,Subscription,AtsCvPurchase,Transaction,Faq,StripeWebhookLog}.php` |
| **Seeders** | `database/seeders/{PlanSeeder,VatRateSeeder,FaqSeeder}.php` |
| **Pricing page** (Phase 2) | `app/Http/Controllers/PricingController.php` + `resources/views/pricing/index.blade.php` |
| **Stripe** (Phase 3) | `app/Services/StripeService.php`, `app/Http/Controllers/SubscriptionController.php`, `StripeWebhookController.php`, `app/Console/Commands/SyncStripePlans.php` |
| **ATS pipeline** (Phase 4) | `app/Services/{AffindaService,OpenAiCvRewriter}.php`, `app/Jobs/GenerateAtsCv.php`, `app/Http/Controllers/AtsCvController.php`, `resources/views/ats/*.blade.php` |
| **Filament admin** (Phase 5) | `app/Filament/Saas/Resources/*` (7 resources) + `Widgets/*` (3 widgets) + `app/Providers/Filament/SaasPanelProvider.php` |

## One-time deploy steps

### 1. Environment

Add to `.env`:

```bash
# Stripe — from https://dashboard.stripe.com/apikeys
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...   # set after creating webhook (step 5)

# OpenAI — https://platform.openai.com/api-keys
OPENAI_API_KEY=sk-...
OPENAI_MODEL=gpt-4o-mini

# Affinda — https://app.affinda.com/account/api-keys
AFFINDA_API_KEY=...
AFFINDA_WORKSPACE=...
```

> Note: `config/services.php` is git-ignored in this project — keep the
> file on the server but don't commit it.

### 2. Migrate + seed

```bash
php artisan migrate
php artisan db:seed --class=PlanSeeder
php artisan db:seed --class=VatRateSeeder
php artisan db:seed --class=FaqSeeder
php artisan storage:link
```

### 3. Sync local plans + VAT to Stripe

```bash
php artisan stripe:sync
```

This creates the Stripe `Product` for each plan, then `Price` rows for
monthly/yearly/one-time, and Stripe `TaxRate` rows for each country's VAT.

If you change a plan's price in Filament later, re-run `stripe:sync` to push
the new price to Stripe. (The old Stripe Price stays — Stripe never deletes
Prices, but you can archive them in the dashboard.)

### 4. Queue worker

ATS CV generation runs as a queued job. On the server:

```bash
php artisan queue:work --queue=default --tries=3 --max-time=3600
```

Put this under a process supervisor (Supervisor / systemd / Laravel
Horizon — whatever the host uses).

### 5. Stripe webhook

In the Stripe dashboard → Developers → Webhooks → Add endpoint:

- **URL:** `https://fulltimez.com/stripe/webhook`
- **Events to listen for:**
  - `checkout.session.completed`
  - `invoice.paid`
  - `invoice.payment_failed`
  - `customer.subscription.created`
  - `customer.subscription.updated`
  - `customer.subscription.deleted`
  - `payment_intent.succeeded`
  - `payment_intent.payment_failed`

Copy the webhook signing secret and put it in `STRIPE_WEBHOOK_SECRET`.

### 6. Filament admin

Browse to `https://fulltimez.com/saas` — login with an existing **admin**
user (role slug `admin`). Non-admin users are blocked at the gate.

The panel includes:

- **Dashboard** — MRR, this-month revenue, all-time revenue, active subs,
  doughnut chart of subs-by-country, recent transactions table
- **Billing** → Plans, VAT Rates
- **Customers** → Subscriptions, ATS CV Purchases, Transactions
- **Content** → FAQs
- **System** → Webhook Logs

## User flow (production)

```
Visitor lands on pk.fulltimez.com / ae.fulltimez.com / sa.fulltimez.com
or fulltimez.com (geo-redirect to nearest)
        ↓
Browse /pricing — sees plans in USD with their country's VAT added
        ↓
Click "Subscribe Now" (Starter / Pro)
        ↓
Login as Seeker (only seekers can subscribe; checked in controller)
        ↓
Stripe Checkout (subscription mode, tax rate attached)
        ↓
Stripe webhook → DB:
   • subscriptions row created (status=active)
   • transactions row created
   • user.stripe_customer_id saved
        ↓
Redirect to /subscribe/success → /subscriptions (manage)

----

For ATS CV:
Click "Generate ATS CV" → /ats-cv/start/{plan}
   ↓
Upload CV (PDF/DOC/DOCX) + optional target role
   ↓
Stripe Checkout (one-time payment, tax rate attached)
   ↓
Webhook payment_intent.succeeded → AtsCvPurchase status=paid
   → dispatch GenerateAtsCv job
       1. Affinda parse the uploaded CV
       2. OpenAI rewrite (returns ATS-friendly JSON)
       3. DomPDF render via resources/views/ats/pdf/standard.blade.php
       4. Save to storage/app/public/ats-cv/generated/
   → status=completed
   ↓
User downloads PDF from /ats-cv dashboard
```

## Country/VAT logic

- Pricing is **stored in USD**.
- VAT is **calculated per request** based on which subdomain the user is
  on (`App\Services\CountryContext` reads `Host`, resolves country key
  `pk|ae|sa|global`).
- The Stripe Checkout line item gets the country's `tax_rate_id` attached
  so Stripe also stores VAT cleanly on the invoice.
- All three values (`base_amount_usd`, `vat_amount_usd`, `total_amount_usd`)
  are persisted on `subscriptions`, `ats_cv_purchases`, and `transactions`
  rows so reports remain accurate even if VAT rates change later.

Default seeded VAT: PK 18% (GST), AE 5% (VAT), SA 15% (VAT), Global 0%.
Edit any time in Filament → Billing → VAT Rates.

## Adding a new country

1. Add the country to `config/countries.json` (see `COUNTRY_SUBDOMAINS.md`).
2. Add a VAT rate via Filament (`/saas/vat-rates/create`) with the same
   `country_key` (e.g. `qa`).
3. Run `php artisan stripe:sync` so the Stripe tax rate is registered.
4. Point DNS for the new subdomain at the server.

## Troubleshooting

- **"Plan has no Stripe price"** — run `php artisan stripe:sync`.
- **Webhook returns 400 invalid signature** — check `STRIPE_WEBHOOK_SECRET`
  matches the endpoint in Stripe dashboard.
- **ATS CV stuck in `generating`** — check `php artisan queue:listen` is
  running and check `storage/logs/laravel.log` for errors.
- **No transactions in dashboard** — webhook isn't reaching the server.
  Check `Webhook Logs` table in Filament panel (`/saas/stripe-webhook-logs`).
- **Filament login redirects to seeker/employer login** — your user's role
  isn't `admin`. Update `users.role_id` to point at the admin role.
