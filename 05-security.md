# Security Requirements

A hospital system handles **PII and health data (PHI-like)**, so security isn't optional polish — treat it as a first-class requirement from the start, not a phase-2 add-on.

## Authentication
- Laravel Breeze base (hashed passwords via bcrypt/argon2, Laravel defaults are fine).
- Enforce strong password rules (min length 10+, not just "8 chars") via Form Request rules.
- Email verification required before dashboard access.
- Rate-limit login attempts (Laravel's built-in throttle middleware) to prevent brute force.
- Consider 2FA for admin and doctor accounts (Laravel Fortify supports this, or a package) — strongly recommended given data sensitivity.
- Session timeout / auto-logout after inactivity for staff dashboards.

## Authorization
- Every model action goes through a **Policy** — never trust a route param alone (e.g., `/patient/5/records` must check the logged-in user owns or is authorized for patient 5).
- Role-based route middleware (`spatie/laravel-permission`) at the route-group level as a first line of defense; Policies as the real enforcement at the model/action level (defense in depth — don't rely on route grouping alone).
- Doctors can only access their own patients' records (scoped queries + policy check, not just UI hiding).
- Receptionists should NOT have access to clinical notes/diagnosis — only appointment/billing data. Enforce via granular permissions, not role name alone.

## Data Protection
- Encrypt sensitive fields at rest: national ID numbers, medical notes if regulation requires (Laravel's `encrypted` cast on Eloquent attributes).
- Use HTTPS everywhere (enforce via `URL::forceScheme('https')` in production, HSTS header).
- File uploads (lab reports, scans):
  - Validate MIME type + extension, not just extension.
  - Store outside public webroot; serve through a controller that checks authorization before streaming the file (never a direct public URL to a patient document).
  - Virus/malware scan on upload if feasible (e.g., ClamAV integration) given files come from patients/staff.
- Database backups encrypted, access-restricted, retention policy defined.

## Input Validation & Common Web Vulnerabilities
- Form Requests for all input — never trust raw `$request->input()` directly into queries/models.
- Laravel's Eloquent/query builder already parameterizes queries — avoid raw DB queries with string concatenation.
- CSRF protection is on by default for Blade forms — keep it, don't disable it for convenience.
- Escape all Blade output by default (`{{ }}` not `{!! !!}`) — especially patient-entered fields like "reason for visit" which render back in staff dashboards (stored XSS risk).
- Sanitize/validate any rich text fields (doctor bios, blog posts) if a WYSIWYG editor is used — strip disallowed tags server-side, don't trust client-side sanitization alone.
- File name sanitization on upload (don't trust original filename for storage path).

## Audit & Compliance
- `spatie/laravel-activitylog` on all clinical + billing models — who viewed/edited what, and when. Even read-access logging is worth considering for medical records depending on jurisdiction.
- Soft deletes on medical records, appointments, invoices — never hard-delete clinical/financial history; use status flags instead.
- Depending on region, consider what's actually required: **HIPAA** (US), **GDPR** (EU/UK), or local health-data regulations — this determines retention rules, right-to-erasure handling (tricky alongside medical retention laws), and breach-notification obligations. Confirm which jurisdiction applies before finalizing data-handling policy — this is a legal/compliance question, not just a technical one.

## Infrastructure
- `.env` never committed; separate secrets per environment.
- Remove/lock down debug tools (Telescope, Debugbar) in production — they can leak sensitive data if exposed.
- `APP_DEBUG=false` in production (prevents stack traces leaking file paths/queries to end users).
- Rate-limit public-facing endpoints (contact form, appointment booking) to prevent abuse/spam.
- Keep dependencies updated — run `composer audit` / Dependabot regularly, since this app will hold real health data.

## Notification/Communication Privacy
- Avoid putting sensitive clinical details in email/SMS notification bodies (e.g., "You have an appointment" not "Your cancer screening results are ready" in a push notification/SMS that could be seen by someone else). Link to a secure dashboard instead.

## Testing
- Include authorization tests (Pest/PHPUnit) verifying a patient cannot access another patient's records via ID manipulation (IDOR testing) — this is one of the most common real-world failures in systems like this.
