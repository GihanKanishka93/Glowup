<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insertOrIgnore([
            // [
            //     'name' => 'user-create',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'user-edit',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'user-delete',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'user-reset-password',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'user-list',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'suspend-user-list',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'role-create',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'role-edit',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'role-delete',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'role-list',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'room-create',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'room-edit',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'room-delete',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'room-list',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'patient-create',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'patient-edit',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'patient-show',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'patient-delete',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'patient-list',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'admission-create',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'admission-edit',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'admission-delete',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'admission-list',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'admission-medical-create',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'admission-medical-view',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'admission-list',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'report-age-group',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'report-district-wise',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'report-province-wise',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'report-served-periodes',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'daily-visit-list',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'daily-visit-create',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'daily-visit-edit',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'daily-visit-delete',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'item-create',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'item-edit',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'item-delete',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'item-list',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'discharge',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'patientid-edit',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'undo-discharge',
            //     'guard_name' => 'web',
            // ],
            // [
            //     'name' => 'past-room-occupancy-edit',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'room-occupancy-delete',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'upcoming-discharges',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'report-district-admissions',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'report-avg-len-stay',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'counselor-read',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'counselor-create',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'counselor-edit',
            //     'guard_name' => 'web'
            // ],

            // [
            //     'name' => 'counselor-delete',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'admission-rate-chart',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'monthly-report',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'pet-category',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'pet-category-edit',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'pet-category-delete',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'pet-breed',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'breed-edit',
            //     'guard_name' => 'web'
            // ],
            // [
            //     'name' => 'breed-delete',
            //     'guard_name' => 'web'
            // ],
                // [
                //     'name' => 'pet-create',
                //     'guard_name' => 'web',
                // ],
                // [
                //     'name' => 'pet-edit',
                //     'guard_name' => 'web',
                // ],
                // [
                //     'name' => 'pet-show',
                //     'guard_name' => 'web',
                // ],
                // [
                //     'name' => 'pet-delete',
                //     'guard_name' => 'web',
                // ],
                // [
                //     'name' => 'pet-list',
                //     'guard_name' => 'web',
                // ],
                //    [
                //         'name' => 'doctor',
                //         'guard_name' => 'web'
                //     ],
                //     [
                //         'name' => 'doctor-create',
                //         'guard_name' => 'web',
                //     ],
                //     [
                //         'name' => 'edit-doctor',
                //         'guard_name' => 'web'
                //     ],
                //     [
                //         'name' => 'delete-doctor',
                //         'guard_name' => 'web'
                //     ],
                    // [
                    //     'name' => 'doctorid-edit',
                    //     'guard_name' => 'web'
                    // ],
                    // [
                    //     'name' => 'petid-edit',
                    //     'guard_name' => 'web'
                    // ],
                    // [
                    //     'name' => 'bill-create',
                    //     'guard_name' => 'web'
                    // ],
                    // [
                    //     'name' => 'bill-edit',
                    //     'guard_name' => 'web'
                    // ],
                    // [
                    //     'name' => 'bill-delete',
                    //     'guard_name' => 'web'
                    // ],
                    // [
                    //     'name' => 'bill-print',
                    //     'guard_name' => 'web'
                    // ],
                    // [
                    //     'name' => 'bill-list',
                    //     'guard_name' => 'web'
                    // ],
                    // [
                    //     'name' => 'drug-list',
                    //     'guard_name' => 'web'
                    // ],
                    // [
                    //     'name' => 'drug-create',
                    //     'guard_name' => 'web'
                    // ],
                    // [
                    //     'name' => 'drug-edit',
                    //     'guard_name' => 'web'
                    // ],
                    // [
                    //     'name' => 'drug-delete',
                    //     'guard_name' => 'web'
                    // ],
                    // [
                    //     'name' => 'services-list',
                    //     'guard_name' => 'web'
                    // ],
                    // [
                    //     'name' => 'services-create',
                    //     'guard_name' => 'web'
                    // ],
                    // [
                    //     'name' => 'services-edit',
                    //     'guard_name' => 'web'
                    // ],
                    // [
                    //     'name' => 'services-delete',
                    //     'guard_name' => 'web'
                    // ],
                    [
                        'name' => 'vaccination-list',
                        'guard_name' => 'web'
                    ],
                    [
                        'name' => 'vaccination-create',
                        'guard_name' => 'web'
                    ],
                    [
                        'name' => 'vaccination-edit',
                        'guard_name' => 'web'
                    ],
                    [
                        'name' => 'vaccination-delete',
                        'guard_name' => 'web'
                    ],

        ]);
    }
}