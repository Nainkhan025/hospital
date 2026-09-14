<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles/permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ── Permissions ──────────────────────────────────────────────
        $permissions = [
            // Departments
            'department.view', 'department.create', 'department.edit', 'department.delete',

            // Doctors
            'doctor.view', 'doctor.create', 'doctor.edit', 'doctor.delete',

            // Appointments
            'appointment.view-any',   // admin/reception can see all
            'appointment.view-own',   // patient/doctor sees own
            'appointment.create',
            'appointment.edit',
            'appointment.cancel',
            'appointment.confirm',
            'appointment.complete',

            // Patient records
            'record.view-own',        // patient sees own records
            'record.view-patient',    // doctor sees their patient's records
            'record.create',
            'record.edit',

            // Billing
            'invoice.view-own',
            'invoice.view-any',
            'invoice.create',
            'invoice.mark-paid',

            // Admin settings
            'settings.manage',
            'staff.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ── Roles ────────────────────────────────────────────────────

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        // Super admin gets all permissions via gate bypass in AuthServiceProvider

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions([
            'department.view', 'department.create', 'department.edit', 'department.delete',
            'doctor.view', 'doctor.create', 'doctor.edit', 'doctor.delete',
            'appointment.view-any', 'appointment.edit', 'appointment.cancel', 'appointment.confirm', 'appointment.complete',
            'record.view-patient',
            'invoice.view-any', 'invoice.create', 'invoice.mark-paid',
            'settings.manage', 'staff.manage',
        ]);

        $doctor = Role::firstOrCreate(['name' => 'doctor']);
        $doctor->syncPermissions([
            'appointment.view-own', 'appointment.complete',
            'record.view-patient', 'record.create', 'record.edit',
            'invoice.view-any',
        ]);

        $receptionist = Role::firstOrCreate(['name' => 'receptionist']);
        $receptionist->syncPermissions([
            'appointment.view-any', 'appointment.create', 'appointment.edit',
            'appointment.cancel', 'appointment.confirm',
            'invoice.view-any', 'invoice.create', 'invoice.mark-paid',
        ]);

        $patient = Role::firstOrCreate(['name' => 'patient']);
        $patient->syncPermissions([
            'appointment.view-own', 'appointment.create', 'appointment.cancel',
            'record.view-own',
            'invoice.view-own',
        ]);

        $this->command->info('Roles and permissions seeded successfully.');
    }
}
