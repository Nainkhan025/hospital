<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Cardiology',        'icon' => '❤️',  'description' => 'Heart and cardiovascular system care.'],
            ['name' => 'Neurology',          'icon' => '🧠',  'description' => 'Brain, spinal cord, and nervous system disorders.'],
            ['name' => 'Orthopedics',        'icon' => '🦴',  'description' => 'Bones, joints, ligaments, tendons, and muscles.'],
            ['name' => 'Pediatrics',         'icon' => '👶',  'description' => 'Medical care for infants, children, and adolescents.'],
            ['name' => 'Dermatology',        'icon' => '🩺',  'description' => 'Skin, hair, and nail conditions.'],
            ['name' => 'Ophthalmology',      'icon' => '👁️', 'description' => 'Eye care and vision disorders.'],
            ['name' => 'Gynecology',         'icon' => '🌸',  'description' => 'Women\'s reproductive health.'],
            ['name' => 'General Surgery',    'icon' => '🔬',  'description' => 'Surgical procedures for general conditions.'],
            ['name' => 'Internal Medicine',  'icon' => '💊',  'description' => 'Diagnosis and non-surgical treatment of adult diseases.'],
            ['name' => 'Emergency Medicine', 'icon' => '🚑',  'description' => 'Immediate care for urgent and life-threatening conditions.'],
        ];

        foreach ($departments as $i => $dept) {
            Department::firstOrCreate(
                ['slug' => Str::slug($dept['name'])],
                [
                    'name'        => $dept['name'],
                    'description' => $dept['description'],
                    'icon'        => $dept['icon'],
                    'is_active'   => true,
                    'sort_order'  => $i + 1,
                ]
            );
        }

        $this->command->info('Departments seeded.');
    }
}
