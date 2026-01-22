<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class floors extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['number' => 'Ground Floor'],
            ['number' => 'Floor 02'],
            ['number' => 'Floor 03'],
            ['number' => 'Floor 04'],
            ['number' => 'Floor 05'],
         
        ];
         // Insert the items into the 'room_items' table
         DB::table('floors')->insert($items);
    }
}
