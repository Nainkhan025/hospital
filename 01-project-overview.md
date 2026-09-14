# Hospital Management System — Project Overview

## Purpose
A full-featured hospital website built in **Laravel** with **Blade** templating for the frontend. Covers public marketing pages, patient appointment booking, doctor/staff management, and an admin backend.

## Stack Decisions
- **Backend:** Laravel 11.x (PHP 8.3+)
- **Frontend:** Blade templates + Tailwind CSS
- **Interactivity:** Alpine.js (light JS) + optional Livewire for dynamic components (appointment calendar, live search, dashboards) without a separate SPA
- **Database:** MySQL 8
- **Auth:** Laravel Breeze (Blade stack) as the base, extended with role-based access via `spatie/laravel-permission`
- **Queue/Jobs:** Database or Redis queue driver for emails/SMS reminders
- **File storage:** Local disk in dev, S3-compatible in production (for lab reports, avatars, documents)

## User Roles
| Role | Description |
|---|---|
| Super Admin | Full system control, manages admins/staff |
| Admin | Manages departments, doctors, content, billing |
| Doctor | Manages own schedule, patient records, prescriptions |
| Receptionist | Handles walk-ins, appointment check-in, front-desk billing |
| Patient | Books appointments, views own records/invoices, messages doctor |

## Core Modules
1. Public website (home, departments, doctors, contact, blog)
2. Authentication & role-based dashboards
3. Appointment booking engine (department → doctor → slot)
4. Patient medical records (EMR-lite)
5. Doctor scheduling & availability
6. Billing & invoicing (with optional online payment)
7. Notifications (email/SMS reminders, status updates)
8. Admin panel (CRUD for all entities, reports)
9. Reviews/ratings for doctors (optional, phase 2)

## Non-Goals (v1)
- No native mobile app
- No multi-hospital/multi-tenant support (single hospital, multiple departments/branches as data, not tenants)
- No deep insurance-claims integration (can be added later)

## Open Questions (fill in before build starts)
- Payment gateway required, or billing records only?
- SMS provider (Twilio, Vonage, local provider)?
- Do doctors need video consultation (telemedicine) in v1?
- Branch/location support (single site vs multiple hospital branches)?
