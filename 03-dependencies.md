# Dependencies

## Core (Composer)
| Package | Purpose |
|---|---|
| `laravel/laravel` (11.x) | Framework |
| `laravel/breeze` | Auth scaffolding (Blade stack) |
| `spatie/laravel-permission` | Roles & permissions (admin, doctor, patient, receptionist) |
| `livewire/livewire` | Dynamic UI without full SPA (appointment picker, dashboards) |
| `spatie/laravel-medialibrary` | File uploads (avatars, lab reports, documents) attached to models |
| `barryvdh/laravel-dompdf` | Generate PDF invoices/prescriptions |
| `spatie/laravel-activitylog` | Audit trail (who changed what, esp. patient records) |
| `laravel/scout` + `algolia` or `meilisearch/meilisearch-php` (optional) | Doctor/department search |
| `pusher/pusher-php-server` or `laravel/reverb` (optional) | Real-time notifications |
| `twilio/sdk` or provider SDK (optional) | SMS appointment reminders |
| `laravel/cashier` (optional) | If subscription/payment billing needed via Stripe |
| `stripe/stripe-php` (optional) | Direct one-off payments |

## Dev / Quality
| Package | Purpose |
|---|---|
| `laravel/pint` | Code style (PSR-12) |
| `phpstan/phpstan` + `larastan/larastan` | Static analysis |
| `pestphp/pest` or `phpunit/phpunit` | Testing |
| `laravel/telescope` | Local debugging (requests, queries, jobs) — **remove/restrict in production** |
| `barryvdh/laravel-debugbar` | Local dev only |
| `nunomaduro/collision` | Better CLI error output (ships with Laravel) |

## Frontend (npm)
| Package | Purpose |
|---|---|
| `tailwindcss` | Styling |
| `alpinejs` | Light interactivity (dropdowns, modals) |
| `@alpinejs/mask` (optional) | Input masking (phone numbers) |
| `flatpickr` or `Tailwind-friendly date picker` | Appointment date selection |
| `chart.js` (optional) | Admin dashboard analytics |
| `vite` | Asset bundling (Laravel default) |

## Infrastructure / Services
- MySQL 8 (or MariaDB 10.6+)
- Redis (queues, cache, session — recommended for production)
- Mail provider (SMTP, Postmark, SES, Mailgun) for transactional email
- SMS provider (if reminders needed): Twilio, Vonage, or local gateway
- Object storage (S3-compatible) for uploaded medical files in production
- Supervisor (or equivalent) to keep queue workers running
- Cron entry for Laravel's scheduler (`* * * * * php artisan schedule:run`)

## Notes on Choices
- **Livewire over a JS SPA**: keeps everything in Blade/PHP, matches the "Blade frontend" requirement, avoids a separate API layer for internal UI.
- **spatie/laravel-permission over custom roles table**: battle-tested, avoids reinventing gates/policies wiring.
- **spatie/laravel-medialibrary** handles file validation, conversions (thumbnails for scanned docs), and storage disk abstraction cleanly — useful since lab reports/scans are a near-certain requirement.
- Payment/SMS packages are marked optional — confirm requirements before adding (avoid unused dependencies/attack surface).
