<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class patient_relationships extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('relationships')->insertOrIgnore([
            ['name' => 'Father'],
            ['name' => 'Mother'],
            ['name' => 'Other'],
            ]);
}
}