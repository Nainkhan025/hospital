# Build Roadmap

## Phase 0 — Setup
- [ ] Init Laravel project, configure `.env`, MySQL connection
- [ ] Install Breeze (Blade stack), Tailwind, Alpine
- [ ] Install spatie/laravel-permission, define roles/permissions seeder
- [ ] Set up base layout (`layouts/app.blade.php`, `layouts/dashboard.blade.php`), shared Blade components
- [ ] Configure queue driver, mail driver (local: log/mailhog)

## Phase 1 — MVP
- [ ] Migrations: users, patient_profiles, doctor_profiles, departments, appointments, doctor_schedules
- [ ] Seeders: departments, sample doctors, demo admin
- [ ] Public pages: home, departments, doctor listing/profile, contact
- [ ] Auth flow + role-based dashboard redirect
- [ ] Appointment booking flow (department → doctor → slot → confirm), with double-booking prevention
- [ ] Patient dashboard: upcoming/past appointments
- [ ] Doctor dashboard: schedule view, appointment status update
- [ ] Admin: CRUD departments/doctors, appointment oversight
- [ ] Email notifications: booking confirmation, cancellation
- [ ] Basic policies/authorization tests for appointments

## Phase 2 — Clinical & Billing
- [ ] Medical records module (doctor create/view, patient view own)
- [ ] Document upload (lab reports/scans) with secure serving
- [ ] Invoices + invoice items, mark-paid flow
- [ ] PDF generation (invoice, prescription summary)
- [ ] Activity log on clinical/financial models
- [ ] Reception dashboard (walk-in booking, check-in)

## Phase 3 — Polish & Scale
- [ ] SMS reminders (if provider confirmed)
- [ ] Online payment integration (if confirmed)
- [ ] Reviews/ratings + moderation
- [ ] Admin reports/analytics dashboard (charts)
- [ ] Blog/news module
- [ ] Performance pass: caching public pages, query optimization, indexing review
- [ ] Security pass: pentest-style review, IDOR checks, rate limiting, dependency audit

## Phase 4 — Stretch
- [ ] Telemedicine/video consult
- [ ] In-dashboard messaging (patient ↔ doctor)
- [ ] Multi-branch/location support
- [ ] 2FA rollout for staff accounts

---

## Before Handing This Off (checklist)
- [ ] Confirm Laravel version target (11 vs 12) and PHP version on hosting
- [ ] Confirm payment gateway (or none for v1)
- [ ] Confirm SMS provider (or email-only for v1)
- [ ] Confirm applicable data regulation (HIPAA/GDPR/local) — affects retention & encryption requirements
- [ ] Confirm single hospital vs multi-branch
- [ ] Confirm whether patients self-register or are only created by staff
