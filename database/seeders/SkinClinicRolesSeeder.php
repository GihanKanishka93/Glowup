<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SkinClinicRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions for a skin clinic
        $permissions = [
            // Patient Management
            'patient-list',
            'patient-create',
            'patient-edit',
            'patient-delete',
            'patient-view',

            // Billing & Payments
            'bill-list',
            'bill-create',
            'bill-edit',
            'bill-delete',
            'bill-print',
            'bill-email',

            // Doctor Management
            'doctor-list',
            'doctor-create',
            'doctor-edit',
            'doctor-delete',

            // Treatment Management
            'treatment-create',
            'treatment-edit',
            'treatment-view',
            'treatment-delete',

            // Admission Management
            'admission-list',
            'admission-create',
            'admission-edit',
            'admission-delete',

            // Reports
            'report-view',
            'report-monthly',
            'report-doctor',
            'report-billing',

            // Settings & Configuration
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-reset-password',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'service-manage',
            'drug-list',
            'drug-create',
            'drug-edit',
            'drug-delete',
            'room-manage',
            'suspend-user-list',

            // Daily Operations
            'daily-visit-create',
            'daily-visit-edit',
            'daily-visit-view',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Head Doctor Role
        $headDoctor = Role::firstOrCreate(['name' => 'Head Doctor']);
        $headDoctor->syncPermissions([
            // Full patient access
            'patient-list',
            'patient-create',
            'patient-edit',
            'patient-delete',
            'patient-view',

            // Full billing access
            'bill-list',
            'bill-create',
            'bill-edit',
            'bill-delete',
            'bill-print',
            'bill-email',

            // Doctor management
            'doctor-list',
            'doctor-create',
            'doctor-edit',
            'doctor-delete',

            // Full treatment access
            'treatment-create',
            'treatment-edit',
            'treatment-view',
            'treatment-delete',

            // Admission access
            'admission-list',
            'admission-create',
            'admission-edit',
            'admission-delete',

            // All reports
            'report-view',
            'report-monthly',
            'report-doctor',
            'report-billing',

            // Settings (limited)
            'user-list',
            'service-manage',
            'drug-list',
            'drug-create',
            'drug-edit',
            'drug-delete',
            'room-manage',

            // Daily operations
            'daily-visit-create',
            'daily-visit-edit',
            'daily-visit-view',
        ]);

        // Create Doctor Role
        $doctor = Role::firstOrCreate(['name' => 'Doctor']);
        $doctor->syncPermissions([
            // Patient access
            'patient-list',
            'patient-create',
            'patient-edit',
            'patient-view',

            // Billing access
            'bill-list',
            'bill-create',
            'bill-edit',
            'bill-print',
            'bill-email',

            // Treatment access
            'treatment-create',
            'treatment-edit',
            'treatment-view',

            // Limited admission access
            'admission-list',
            'admission-create',
            'admission-edit',

            // Limited reports
            'report-view',
            'report-doctor',

            // Daily operations
            'daily-visit-create',
            'daily-visit-edit',
            'daily-visit-view',

            // View only
            'doctor-list',
            'service-manage',
            'drug-list',
            'drug-create',
            'drug-edit',
            'drug-delete',
        ]);

        // Create Cashier Role
        $cashier = Role::firstOrCreate(['name' => 'Cashier']);
        $cashier->syncPermissions([
            // Limited patient access
            'patient-list',
            'patient-view',
            'patient-create',
            'patient-edit',

            // Full billing access
            'bill-list',
            'bill-create',
            'bill-edit',
            'bill-print',
            'bill-email',

            // View treatments
            'treatment-view',

            // Billing reports only
            'report-view',
            'report-billing',
            'report-monthly',

            // View doctors
            'doctor-list',
        ]);

        // Update Admin and SAdmin if they exist
        $admin = Role::where('name', 'Admin')->first();
        if ($admin) {
            $admin->syncPermissions(Permission::all());
        }

        $sadmin = Role::where('name', 'SAdmin')->first();
        if ($sadmin) {
            $sadmin->syncPermissions(Permission::all());
        }

        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('Created roles: Head Doctor, Doctor, Cashier');
    }
}
