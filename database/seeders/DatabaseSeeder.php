<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call(permissionSeeder::class);
      //  $this->call(floorSeeder::class);
        $this->call(SriLankanProvincesSeeder::class);
        $this->call(SriLankanDistrictSeeder::class);
        $this->call(patient_relationships::class);
        $this->call(room_inventory_items::class);
        $this->call(floors::class);
        $this->call(rooms::class);
        $this->call(SkinLookupsSeeder::class);
        $this->call(ServicesSeeder::class);

        $adminRole = Role::firstOrCreate(
            ['name' => 'SAdmin', 'guard_name' => 'web'],
            ['name' => 'SAdmin', 'guard_name' => 'web']
        );
        $permissions = Permission::pluck('id', 'id')->all();
        $adminRole->syncPermissions($permissions);

        $user = \App\Models\User::firstOrCreate(
            ['user_name' => 'admin'],
            [
                'first_name'=> 'HealthCare.LK',
                'last_name'=> '(Pvt) Ltd',
                'user_name'=> 'admin',
                'contact_number'=> '0710490855',
                'designation'=> 'Solution Provider',
                'email'=> 'docpphealthcarelk@gmail.com',
                'password'=> Hash::make('123456'),
                'created_by'=> '1',
            ]
        );

        if (!$user->hasRole('SAdmin')) {
            $user->assignRole($adminRole);
        }
    }
}
