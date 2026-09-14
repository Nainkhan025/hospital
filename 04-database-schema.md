# Database Schema (Draft)

Naming convention: snake_case tables, plural. Soft deletes on patient-facing and clinical tables (`deleted_at`).

## users
- id
- name
- email (unique)
- phone
- password
- avatar_path (nullable)
- email_verified_at
- timestamps
> Roles/permissions handled by `spatie/laravel-permission` pivot tables (`model_has_roles`, `roles`, `permissions`).

## patient_profiles (1:1 with users where role=patient)
- id
- user_id (FK)
- date_of_birth
- gender
- blood_group (nullable)
- address
- emergency_contact_name
- emergency_contact_phone
- national_id / passport (nullable, encrypted)
- timestamps

## doctor_profiles (1:1 with users where role=doctor)
- id
- user_id (FK)
- department_id (FK)
- specialization
- bio (text)
- qualifications (text)
- years_experience
- consultation_fee (decimal)
- is_active (bool)
- timestamps

## departments
- id
- name
- slug
- description
- icon/image
- is_active
- timestamps

## doctor_schedules
- id
- doctor_id (FK → doctor_profiles)
- day_of_week (0–6) OR specific_date (for exceptions/holidays)
- start_time
- end_time
- slot_duration_minutes
- is_available (bool)
- timestamps

## appointments
- id
- patient_id (FK → users)
- doctor_id (FK → doctor_profiles)
- department_id (FK)
- appointment_date
- appointment_time
- status (enum: pending, confirmed, completed, cancelled, no_show)
- reason (text)
- notes (internal, staff-only)
- booked_by (FK → users, nullable — for receptionist-created bookings)
- cancelled_reason (nullable)
- timestamps

## medical_records
- id
- patient_id (FK)
- doctor_id (FK)
- appointment_id (FK, nullable)
- diagnosis (text)
- prescription (text or related table, see below)
- notes
- timestamps
- deleted_at (soft delete — clinical data retention matters)

## prescriptions (optional normalized version instead of flat text)
- id
- medical_record_id (FK)
- medicine_name
- dosage
- frequency
- duration
- instructions
- timestamps

## documents (via spatie/medialibrary or custom)
- id
- documentable_type / documentable_id (polymorphic — attach to medical_records, patient_profiles)
- file_path
- file_type (lab_report, scan, prescription_scan, other)
- uploaded_by (FK → users)
- timestamps

## invoices
- id
- patient_id (FK)
- appointment_id (FK, nullable)
- invoice_number (unique)
- amount
- status (enum: unpaid, paid, partially_paid, refunded, cancelled)
- due_date
- timestamps

## invoice_items
- id
- invoice_id (FK)
- description
- quantity
- unit_price
- total
- timestamps

## payments
- id
- invoice_id (FK)
- amount
- method (cash, card, online)
- transaction_reference (nullable, for gateway payments)
- paid_at
- timestamps

## notifications
> Use Laravel's built-in `notifications` table (polymorphic) for in-app + queued email/SMS notifications.

## activity_log
> Provided by `spatie/laravel-activitylog` — tracks changes to sensitive models (medical_records, appointments, invoices).

## reviews (phase 2, optional)
- id
- doctor_id (FK)
- patient_id (FK)
- appointment_id (FK)
- rating (1–5)
- comment
- is_approved (bool, admin-moderated)
- timestamps

---

## Key Relationships
- `users` 1:1 `patient_profiles` or `doctor_profiles` (based on role)
- `doctor_profiles` N:1 `departments`
- `doctor_profiles` 1:N `doctor_schedules`
- `appointments` N:1 `users` (patient), N:1 `doctor_profiles`
- `medical_records` N:1 `appointments`, N:1 `users` (patient), N:1 `doctor_profiles`
- `invoices` 1:N `invoice_items`, 1:N `payments`

## Indexing Notes
- Index `appointments(doctor_id, appointment_date)` — heavily queried for availability checks.
- Unique constraint on `(doctor_id, appointment_date, appointment_time)` to prevent double-booking at the DB level, not just app level.
- Index `medical_records(patient_id)`, `invoices(patient_id, status)`.
