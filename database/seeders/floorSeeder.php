<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class floorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('floors')->insertOrIgnore([
            ['number' => '1'],
            ['number' => '2'],
            ['number' => '3'],
            ['number' => '4'],
            ['number' => '5']
            ]);
    }
}
