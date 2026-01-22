<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class room_inventory_items extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['name' => 'ඇඳ ඇතිරිලි (03)'],
            ['name' => 'ඇඳ ඇතිරිලි (05)'],
            ['name' => 'කොට්ට උර (03)'],
            ['name' => 'කොට්ට උර (05)'],
            ['name' => 'රූපවාහිනී දුරස්ථ පාලකය (TV Remote)'],
            ['name' => 'වායු සමීකරණ දුරස්ථ පාලකය (AC Remote)'],
            ['name' => 'ෆ්ලෑෂ් ධාවකය (Flash Drive)'],
            ['name' => 'ලී තැටිය (Wooden Tray)'],
            ['name' => 'උණු වතුර බෝතලය (රිදී පාට)'],
            ['name' => 'කෝප්පය (Mug)'],
            ['name' => 'ඇඳුම් රාක්කය (Clothes Rack)'],
            ['name' => 'රෙදි බෑගයේ රෙදි කටු 20ක් (20 Clothes Pegs)'],
            ['name' => 'කුණු බක්කිය (Dustbin)'],
            ['name' => 'යතුරු 3ක් සහිත කාමර යතුර (x1 දොර යතුර සහ x2 ලොකර් යතුරු)'],
            ['name' => 'ගේට් පාස් (Gate Pass)'],
            ['name' => 'කළ යුතු සහ නොකළ යුතු දේ ලැයිස්තුව (අතිශයින්ම වැදගත්)'],
            ['name' => 'රෝ ද පුටුව'],
            // Add more items as needed
        ];

        // Insert the items into the 'room_items' table
        DB::table('items')->insert($items);
    }
}
