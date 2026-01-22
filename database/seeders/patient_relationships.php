<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class patient_relationships extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Schema::hasTable('relationships')) {
            // Table not present in this deployment; skip seeding.
            return;
        }

        DB::table('relationships')->insertOrIgnore([
            ['name' => 'Father'],
            ['name' => 'Mother'],
            ['name' => 'Other'],
        ]);
}
}
