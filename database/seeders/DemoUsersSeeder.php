<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\DoctorProfile;
use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    public function run(): void
    {
        // ── Super Admin ───────────────────────────────────────────────
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@hospital.test'],
            [
                'name'              => 'Super Admin',
                'phone'             => '+1000000000',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('super_admin');

        // ── Admin ─────────────────────────────────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'admin@hospital.test'],
            [
                'name'              => 'Hospital Admin',
                'phone'             => '+1000000001',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // ── Receptionist ──────────────────────────────────────────────
        $receptionist = User::firstOrCreate(
            ['email' => 'reception@hospital.test'],
            [
                'name'              => 'Front Desk',
                'phone'             => '+1000000002',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $receptionist->assignRole('receptionist');

        // ── Seed Doctors Across All 10 Departments ────────────────────
        $departments = Department::all()->keyBy('slug');

        $doctors = [
            [
                'user'    => ['name' => 'Dr. Sarah Mitchell', 'email' => 'dr.mitchell@hospital.test'],
                'profile' => ['dept_slug' => 'cardiology',  'specialization' => 'Interventional Cardiology', 'years_experience' => 12, 'consultation_fee' => 150],
            ],
            [
                'user'    => ['name' => 'Dr. James Thornton', 'email' => 'dr.thornton@hospital.test'],
                'profile' => ['dept_slug' => 'neurology',   'specialization' => 'Neurodegenerative Diseases',  'years_experience' => 9, 'consultation_fee' => 130],
            ],
            [
                'user'    => ['name' => 'Dr. Aisha Rahman',   'email' => 'dr.rahman@hospital.test'],
                'profile' => ['dept_slug' => 'orthopedics', 'specialization' => 'Sports Medicine & Joint Replacement', 'years_experience' => 7, 'consultation_fee' => 120],
            ],
            [
                'user'    => ['name' => 'Dr. Emily Carter',   'email' => 'dr.carter@hospital.test'],
                'profile' => ['dept_slug' => 'pediatrics',  'specialization' => 'Pediatric Care & Immunology', 'years_experience' => 10, 'consultation_fee' => 110],
            ],
            [
                'user'    => ['name' => 'Dr. Michael Chang',  'email' => 'dr.chang@hospital.test'],
                'profile' => ['dept_slug' => 'dermatology', 'specialization' => 'Cosmetic & Clinical Dermatology', 'years_experience' => 8, 'consultation_fee' => 140],
            ],
            [
                'user'    => ['name' => 'Dr. Robert Vance',   'email' => 'dr.vance@hospital.test'],
                'profile' => ['dept_slug' => 'ophthalmology', 'specialization' => 'Retinal Surgery & Glaucoma', 'years_experience' => 15, 'consultation_fee' => 160],
            ],
            [
                'user'    => ['name' => 'Dr. Elena Rostova',  'email' => 'dr.rostova@hospital.test'],
                'profile' => ['dept_slug' => 'gynecology',  'specialization' => 'Obstetrics & Maternal Care', 'years_experience' => 11, 'consultation_fee' => 145],
            ],
            [
                'user'    => ['name' => 'Dr. Marcus Brody',   'email' => 'dr.brody@hospital.test'],
                'profile' => ['dept_slug' => 'general-surgery', 'specialization' => 'Laparoscopic & Abdominal Surgery', 'years_experience' => 14, 'consultation_fee' => 175],
            ],
            [
                'user'    => ['name' => 'Dr. David Sterling', 'email' => 'dr.sterling@hospital.test'],
                'profile' => ['dept_slug' => 'internal-medicine', 'specialization' => 'Endocrinology & Chronic Care', 'years_experience' => 13, 'consultation_fee' => 135],
            ],
            [
                'user'    => ['name' => 'Dr. Hannah Abbott',  'email' => 'dr.abbott@hospital.test'],
                'profile' => ['dept_slug' => 'emergency-medicine', 'specialization' => 'Trauma & Emergency Care', 'years_experience' => 9, 'consultation_fee' => 125],
            ],
        ];

        foreach ($doctors as $d) {
            $dept = $departments->get($d['profile']['dept_slug']);
            if (!$dept) continue;

            $userRecord = User::firstOrCreate(
                ['email' => $d['user']['email']],
                array_merge($d['user'], [
                    'phone'             => '+10000000' . rand(10, 99),
                    'password'          => Hash::make('password'),
                    'email_verified_at' => now(),
                ])
            );
            $userRecord->assignRole('doctor');

            $docProfile = DoctorProfile::firstOrCreate(
                ['user_id' => $userRecord->id],
                [
                    'department_id'    => $dept->id,
                    'specialization'   => $d['profile']['specialization'],
                    'years_experience' => $d['profile']['years_experience'],
                    'consultation_fee' => $d['profile']['consultation_fee'],
                    'bio'              => 'Experienced specialist committed to evidence-based compassionate clinical care.',
                    'qualifications'   => 'MBBS, MD',
                    'is_active'        => true,
                ]
            );

            // Seed default Monday-Friday work schedule (09:00 - 17:00)
            for ($day = 1; $day <= 5; $day++) {
                DoctorSchedule::firstOrCreate(
                    [
                        'doctor_profile_id' => $docProfile->id,
                        'day_of_week'       => $day,
                    ],
                    [
                        'start_time'            => '09:00:00',
                        'end_time'              => '17:00:00',
                        'slot_duration_minutes' => 30,
                        'is_available'          => true,
                    ]
                );
            }
        }

        // ── Seed Multiple Demo Patients ────────────────────────────────
        $patients = [
            ['name' => 'John Doe',       'email' => 'patient@hospital.test', 'phone' => '+1999999999'],
            ['name' => 'Alice Johnson',  'email' => 'alice@hospital.test',   'phone' => '+1999999991'],
            ['name' => 'Robert Smith',   'email' => 'robert@hospital.test',  'phone' => '+1999999992'],
            ['name' => 'Emma Watson',    'email' => 'emma@hospital.test',    'phone' => '+1999999993'],
            ['name' => 'Carlos Mendez',  'email' => 'carlos@hospital.test',  'phone' => '+1999999994'],
        ];

        foreach ($patients as $p) {
            $patUser = User::firstOrCreate(
                ['email' => $p['email']],
                [
                    'name'              => $p['name'],
                    'phone'             => $p['phone'],
                    'password'          => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            $patUser->assignRole('patient');
        }

        $this->command->info('Demo users and doctors seeded successfully.');
    }
}
