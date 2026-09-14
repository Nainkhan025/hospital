# Modules & Feature Breakdown

## 1. Public Website
- Home page (hero, featured departments, top doctors, stats, testimonials/CTA)
- About page (hospital history, mission, facilities)
- Departments listing + individual department page (doctors in that dept, services offered)
- Doctor listing (filter by department, search by name) + individual doctor profile (bio, qualifications, schedule, "Book Appointment" CTA)
- Contact page (form, map embed, hospital info)
- Blog/News (optional — health tips, hospital announcements)
- FAQ page

## 2. Auth & Dashboards
- Register/login (patients self-register; staff accounts created by admin)
- Role-based redirect after login
- Shared dashboard shell with role-specific sidebar/widgets
- Profile management (update info, change password, upload avatar)

## 3. Appointment Booking
- Public booking flow (department → doctor → date/time → confirm) — works for guests (creates account) or logged-in patients
- Patient dashboard: view upcoming/past appointments, cancel/reschedule (within policy window)
- Doctor dashboard: daily/weekly schedule view, mark appointment as completed/no-show
- Reception dashboard: create walk-in appointments, check-in patients, manage queue
- Admin: full appointment oversight, manual overrides

## 4. Patient Records (EMR-lite)
- Doctor creates medical record post-appointment (diagnosis, prescription, notes)
- Patient can view their own records + download PDF prescription/summary
- Upload lab reports/scans (by doctor, receptionist, or patient depending on policy)
- Record history timeline per patient

## 5. Doctor Management
- Admin CRUD: add/edit doctor profiles, assign to department
- Doctor availability/schedule management (recurring weekly hours + one-off exceptions/leave)
- Doctor's own dashboard to update their own schedule (if allowed) and bio

## 6. Billing & Invoicing
- Auto-generate invoice on appointment completion (consultation fee) or manual invoice creation
- Add line items (tests, procedures, medication)
- Mark as paid (cash/card at desk) or online payment (if gateway integrated)
- Patient can view/download invoices
- Admin billing reports (revenue by department/doctor/date range)

## 7. Notifications
- Appointment confirmation, reminder (24h before), cancellation, reschedule — via email (+ SMS if configured)
- Invoice created / payment received notification
- In-app notification bell for dashboard users

## 8. Admin Panel
- Dashboard with key stats (appointments today, revenue this month, new patients, doctor utilization)
- CRUD: departments, doctors, staff/receptionists, content (blog/pages), FAQs
- Reports: appointments, revenue, doctor performance
- Settings: hospital info, business hours, booking rules (cancellation window, slot duration defaults)

## 9. Reviews & Ratings (Phase 2)
- Patients rate doctor after completed appointment
- Admin moderation queue before publishing
- Average rating shown on doctor profile

## Feature Priority (suggested phases)
**Phase 1 (MVP):** Public site, auth, appointment booking, basic doctor/department management, patient dashboard, admin dashboard, email notifications.
**Phase 2:** Medical records, billing/invoicing, PDF generation, doctor schedule management UI.
**Phase 3:** SMS reminders, online payments, reviews, reports/analytics, blog.
**Phase 4 (stretch):** Telemedicine/video consult, patient portal messaging with doctor, multi-branch support.
