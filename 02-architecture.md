# Architecture

## High-Level Structure
```
app/
  Models/
  Http/
    Controllers/
      Admin/
      Doctor/
      Patient/
      Reception/
      Auth/            (from Breeze)
    Requests/           (Form Request validation classes)
    Middleware/
      EnsureRole.php
  Livewire/              (if using Livewire for dynamic UI)
  Policies/               (per-model authorization)
  Services/               (business logic: AppointmentService, BillingService, NotificationService)
  Notifications/           (AppointmentReminder, InvoiceCreated, etc.)
  Jobs/                    (SendAppointmentReminder, GenerateInvoicePdf)

resources/
  views/
    layouts/
      app.blade.php        (public layout)
      dashboard.blade.php  (authenticated shell, role-aware sidebar)
    components/            (Blade components: alerts, cards, modals, form inputs)
    public/                (home, about, departments, doctors, contact, blog)
    auth/                  (Breeze scaffolding)
    admin/
    doctor/
    patient/
    reception/

routes/
  web.php                  (public + shared authenticated routes)
  admin.php
  doctor.php
  patient.php
  reception.php
```

## Layered Design
- **Controllers** stay thin — validate via Form Requests, delegate to Services.
- **Services** hold business logic (e.g., `AppointmentService::bookSlot()` checks doctor availability, prevents double-booking, fires notifications).
- **Policies** gate every model action (`PatientRecordPolicy`, `AppointmentPolicy`) so a doctor can only see their own patients, a patient only their own records.
- **Form Requests** centralize validation + authorization per action.
- **Blade components** for reusable UI: `<x-card>`, `<x-status-badge>`, `<x-form.input>`, `<x-appointment-slot-picker>`.

## Routing & Access Pattern
- Public routes: no auth, cacheable pages (home, departments, doctor profiles).
- `/dashboard` redirects based on role after login.
- Role-specific route groups protected by middleware (`role:admin`, `role:doctor`, etc. via spatie/laravel-permission's middleware).
- Route model binding scoped where relevant (e.g., a doctor can only load their own appointment via a scoped binding + policy check, not just route param).

## Real-Time / Dynamic Parts (candidates for Livewire)
- Appointment slot picker (live availability as department/doctor/date change)
- Admin dashboard stats/widgets
- Doctor's daily schedule view
- Live search on doctors/patients tables in admin panel

## Multi-Step Booking Flow
1. Select department
2. Select doctor (filtered by department)
3. Select date → available time slots (AJAX/Livewire, computed from doctor's schedule minus existing bookings)
4. Confirm patient details (auto-filled if logged in) + reason for visit
5. Create appointment (status: `pending` → `confirmed` by staff/doctor, or auto-confirmed depending on settings)
6. Notification sent to patient + doctor/reception

## Caching Strategy
- Cache public pages (departments, doctor listing) with tags, invalidate on admin edit.
- Cache doctor availability computation per day briefly (a few minutes) to avoid recomputation on every request, invalidate on new booking.

## Environments
- Local: Laravel Sail or Herd + MySQL
- Staging/Production: standard LEMP/LAMP or Laravel Forge/Vapor, queue worker + scheduler (cron) running for reminders
