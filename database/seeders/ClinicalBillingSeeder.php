<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\MedicalRecord;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ClinicalBillingSeeder extends Seeder
{
    public function run(): void
    {
        $patients = User::role('patient')->get();
        $doctors  = DoctorProfile::with('department')->get();

        if ($patients->isEmpty() || $doctors->isEmpty()) {
            return;
        }

        $patient1 = $patients->firstWhere('email', 'patient@hospital.test') ?? $patients->first();
        $patient2 = $patients->firstWhere('email', 'alice@hospital.test') ?? $patients->skip(1)->first() ?? $patient1;
        $patient3 = $patients->firstWhere('email', 'robert@hospital.test') ?? $patients->skip(2)->first() ?? $patient1;
        $patient4 = $patients->firstWhere('email', 'emma@hospital.test') ?? $patients->skip(3)->first() ?? $patient1;
        $patient5 = $patients->firstWhere('email', 'carlos@hospital.test') ?? $patients->skip(4)->first() ?? $patient1;

        $docCardio = $doctors->firstWhere('department.slug', 'cardiology') ?? $doctors->first();
        $docNeuro  = $doctors->firstWhere('department.slug', 'neurology') ?? $doctors->skip(1)->first() ?? $docCardio;
        $docOrtho  = $doctors->firstWhere('department.slug', 'orthopedics') ?? $doctors->skip(2)->first() ?? $docCardio;
        $docPedia  = $doctors->firstWhere('department.slug', 'pediatrics') ?? $doctors->skip(3)->first() ?? $docCardio;
        $docDerma  = $doctors->firstWhere('department.slug', 'dermatology') ?? $doctors->skip(4)->first() ?? $docCardio;

        // ── 1. PAST COMPLETED APPOINTMENTS + MEDICAL RECORDS + INVOICES ──────

        // Record 1: Patient 1 Cardiology Checkup (5 days ago)
        $app1 = Appointment::create([
            'patient_id'        => $patient1->id,
            'doctor_profile_id' => $docCardio->id,
            'department_id'     => $docCardio->department_id,
            'appointment_date'  => today()->subDays(5),
            'appointment_time'  => '09:30:00',
            'status'            => 'completed',
            'reason'            => 'Routine hypertension follow-up and chest tightness evaluation.',
            'consultation_fee'  => $docCardio->consultation_fee,
        ]);

        $rec1 = MedicalRecord::create([
            'patient_id'        => $patient1->id,
            'doctor_profile_id' => $docCardio->id,
            'appointment_id'    => $app1->id,
            'diagnosis'         => 'Essential Hypertension (ICD-10 I10) & Stage 1 BP elevation (138/86 mmHg).',
            'treatment_plan'    => 'Prescribed daily antihypertensive medication, salt intake restriction, 30 min daily walking.',
            'notes'             => 'ECG showed normal sinus rhythm. Next follow-up recommended in 30 days.',
            'record_date'       => today()->subDays(5),
        ]);

        $rec1->prescriptions()->createMany([
            [
                'medication_name' => 'Amlodipine Besylate',
                'dosage'          => '5 mg',
                'frequency'       => 'Once daily (morning)',
                'duration'        => '30 days',
            ],
            [
                'medication_name' => 'Lisinopril',
                'dosage'          => '10 mg',
                'frequency'       => 'Once daily (evening)',
                'duration'        => '30 days',
            ],
        ]);

        $inv1 = Invoice::create([
            'patient_id'     => $patient1->id,
            'appointment_id' => $app1->id,
            'invoice_number' => 'INV-20260909-001',
            'subtotal'       => 200.00,
            'tax'            => 10.00,
            'discount'       => 0.00,
            'total_amount'   => 210.00,
            'status'         => 'paid',
            'due_date'       => today()->subDays(2),
        ]);

        $inv1->items()->createMany([
            [
                'description' => 'Specialist Cardiology Consultation',
                'unit_price'  => 150.00,
                'quantity'    => 1,
                'total'       => 150.00,
            ],
            [
                'description' => '12-Lead Electrocardiogram (ECG)',
                'unit_price'  => 50.00,
                'quantity'    => 1,
                'total'       => 50.00,
            ],
        ]);

        $inv1->payments()->create([
            'amount'         => 210.00,
            'payment_method' => 'card',
            'paid_at'        => today()->subDays(5),
        ]);

        // Record 2: Patient 2 Neurology Consultation (3 days ago)
        $app2 = Appointment::create([
            'patient_id'        => $patient2->id,
            'doctor_profile_id' => $docNeuro->id,
            'department_id'     => $docNeuro->department_id,
            'appointment_date'  => today()->subDays(3),
            'appointment_time'  => '11:00:00',
            'status'            => 'completed',
            'reason'            => 'Chronic migraine headache and photosensitivity.',
            'consultation_fee'  => $docNeuro->consultation_fee,
        ]);

        $rec2 = MedicalRecord::create([
            'patient_id'        => $patient2->id,
            'doctor_profile_id' => $docNeuro->id,
            'appointment_id'    => $app2->id,
            'diagnosis'         => 'Migraine without aura, intractable (ICD-10 G43.009).',
            'treatment_plan'    => 'Abortive migraine therapy with Triptans, sleep rhythm regulation, stress management.',
            'notes'             => 'Brain MRI ordered to rule out vascular malformation.',
            'record_date'       => today()->subDays(3),
        ]);

        $rec2->prescriptions()->createMany([
            [
                'medication_name' => 'Sumatriptan Succinate',
                'dosage'          => '50 mg',
                'frequency'       => 'At onset of headache',
                'duration'        => ' As needed (Max 2/day)',
            ],
            [
                'medication_name' => 'Propranolol HCI',
                'dosage'          => '40 mg',
                'frequency'       => 'Twice daily',
                'duration'        => '60 days',
            ],
        ]);

        $inv2 = Invoice::create([
            'patient_id'     => $patient2->id,
            'appointment_id' => $app2->id,
            'invoice_number' => 'INV-20260911-002',
            'subtotal'       => 130.00,
            'tax'            => 6.50,
            'discount'       => 0.00,
            'total_amount'   => 136.50,
            'status'         => 'paid',
            'due_date'       => today()->addDays(2),
        ]);

        $inv2->items()->create([
            'description' => 'Neurology Initial Consultation',
            'unit_price'  => 130.00,
            'quantity'    => 1,
            'total'       => 130.00,
        ]);

        $inv2->payments()->create([
            'amount'         => 136.50,
            'payment_method' => 'insurance',
            'paid_at'        => today()->subDays(3),
        ]);

        // Record 3: Patient 3 Orthopedics Knee Injury (2 days ago)
        $app3 = Appointment::create([
            'patient_id'        => $patient3->id,
            'doctor_profile_id' => $docOrtho->id,
            'department_id'     => $docOrtho->department_id,
            'appointment_date'  => today()->subDays(2),
            'appointment_time'  => '14:00:00',
            'status'            => 'completed',
            'reason'            => 'Right knee swelling and acute painful joint movement post sports.',
            'consultation_fee'  => $docOrtho->consultation_fee,
        ]);

        $rec3 = MedicalRecord::create([
            'patient_id'        => $patient3->id,
            'doctor_profile_id' => $docOrtho->id,
            'appointment_id'    => $app3->id,
            'diagnosis'         => 'Right Meniscal Sprain & Moderate Knee Effusion (ICD-10 S83.201A).',
            'treatment_plan'    => 'RICE protocol (Rest, Ice, Compression, Elevation), knee brace support, physiotherapy.',
            'notes'             => 'X-Ray negative for acute fracture. Follow up after 2 weeks of physical therapy.',
            'record_date'       => today()->subDays(2),
        ]);

        $rec3->prescriptions()->createMany([
            [
                'medication_name' => 'Naproxen Sodium',
                'dosage'          => '500 mg',
                'frequency'       => 'Twice daily after meals',
                'duration'        => '10 days',
            ],
            [
                'medication_name' => 'Omeprazole',
                'dosage'          => '20 mg',
                'frequency'       => 'Once daily (before breakfast)',
                'duration'        => '10 days',
            ],
        ]);

        $inv3 = Invoice::create([
            'patient_id'     => $patient3->id,
            'appointment_id' => $app3->id,
            'invoice_number' => 'INV-20260912-003',
            'subtotal'       => 220.00,
            'tax'            => 11.00,
            'discount'       => 15.00,
            'total_amount'   => 216.00,
            'status'         => 'unpaid',
            'due_date'       => today()->addDays(7),
        ]);

        $inv3->items()->createMany([
            [
                'description' => 'Orthopedic Examination',
                'unit_price'  => 120.00,
                'quantity'    => 1,
                'total'       => 120.00,
            ],
            [
                'description' => 'Right Knee Digital X-Ray (2 Views)',
                'unit_price'  => 100.00,
                'quantity'    => 1,
                'total'       => 100.00,
            ],
        ]);

        // ── 2. TODAY'S APPOINTMENTS (FOR RECEPTION DESK QUEUE) ─────────────

        Appointment::create([
            'patient_id'        => $patient1->id,
            'doctor_profile_id' => $docCardio->id,
            'department_id'     => $docCardio->department_id,
            'appointment_date'  => today(),
            'appointment_time'  => '10:00:00',
            'status'            => 'confirmed',
            'reason'            => 'ECG Result review and medication adjustment.',
            'consultation_fee'  => $docCardio->consultation_fee,
        ]);

        Appointment::create([
            'patient_id'        => $patient4->id,
            'doctor_profile_id' => $docPedia->id,
            'department_id'     => $docPedia->department_id,
            'appointment_date'  => today(),
            'appointment_time'  => '11:30:00',
            'status'            => 'pending',
            'reason'            => 'Pediatric seasonal allergy consultation & vaccination.',
            'consultation_fee'  => $docPedia->consultation_fee,
        ]);

        Appointment::create([
            'patient_id'        => $patient5->id,
            'doctor_profile_id' => $docDerma->id,
            'department_id'     => $docDerma->department_id,
            'appointment_date'  => today(),
            'appointment_time'  => '14:30:00',
            'status'            => 'confirmed',
            'reason'            => 'Eczema flare-up assessment & topical treatment review.',
            'consultation_fee'  => $docDerma->consultation_fee,
        ]);

        // ── 3. FUTURE UPCOMING APPOINTMENTS ─────────────────────────────────

        Appointment::create([
            'patient_id'        => $patient2->id,
            'doctor_profile_id' => $docNeuro->id,
            'department_id'     => $docNeuro->department_id,
            'appointment_date'  => today()->addDays(3),
            'appointment_time'  => '10:30:00',
            'status'            => 'confirmed',
            'reason'            => 'Follow-up MRI report evaluation.',
            'consultation_fee'  => $docNeuro->consultation_fee,
        ]);

        Appointment::create([
            'patient_id'        => $patient3->id,
            'doctor_profile_id' => $docOrtho->id,
            'department_id'     => $docOrtho->department_id,
            'appointment_date'  => today()->addDays(5),
            'appointment_time'  => '15:00:00',
            'status'            => 'pending',
            'reason'            => 'Post-physiotherapy knee joint assessment.',
            'consultation_fee'  => $docOrtho->consultation_fee,
        ]);

        $this->command->info('Clinical billing, appointments, prescriptions, and invoices seeded successfully.');
    }
}

