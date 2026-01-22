<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class rooms extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            ['room_number' => 'R201', 'floor_id' => 2, 'status' => 1],
            ['room_number' => 'R202', 'floor_id' => 2, 'status' => 1],
            ['room_number' => 'R203', 'floor_id' => 2, 'status' => 1],
            ['room_number' => 'R204', 'floor_id' => 2, 'status' => 1],
            ['room_number' => 'R205', 'floor_id' => 2, 'status' => 1],
            ['room_number' => 'R206', 'floor_id' => 2, 'status' => 1],
            ['room_number' => 'R207', 'floor_id' => 2, 'status' => 1],
            ['room_number' => 'R208', 'floor_id' => 2, 'status' => 1],

            ['room_number' => 'R301', 'floor_id' => 3, 'status' => 1],
            ['room_number' => 'R302', 'floor_id' => 3, 'status' => 1],
            ['room_number' => 'R303', 'floor_id' => 3, 'status' => 1],
            ['room_number' => 'R304', 'floor_id' => 3, 'status' => 1],
            ['room_number' => 'R305', 'floor_id' => 3, 'status' => 1],
            ['room_number' => 'R306', 'floor_id' => 3, 'status' => 1],
            ['room_number' => 'R307', 'floor_id' => 3, 'status' => 1],
            ['room_number' => 'R308', 'floor_id' => 3, 'status' => 1],

            ['room_number' => 'R401', 'floor_id' => 4, 'status' => 1],
            ['room_number' => 'R402', 'floor_id' => 4, 'status' => 1],
            ['room_number' => 'R403', 'floor_id' => 4, 'status' => 1],
            ['room_number' => 'R404', 'floor_id' => 4, 'status' => 1],
            ['room_number' => 'R405', 'floor_id' => 4, 'status' => 1],
            ['room_number' => 'R406', 'floor_id' => 4, 'status' => 1],
            ['room_number' => 'R407', 'floor_id' => 4, 'status' => 1],
            ['room_number' => 'R408', 'floor_id' => 4, 'status' => 1],

            ['room_number' => 'R501', 'floor_id' => 5, 'status' => 1],
            ['room_number' => 'R502', 'floor_id' => 5, 'status' => 1],
            ['room_number' => 'R503', 'floor_id' => 5, 'status' => 1],
            ['room_number' => 'R504', 'floor_id' => 5, 'status' => 1],
            ['room_number' => 'R505', 'floor_id' => 5, 'status' => 1],
            ['room_number' => 'R506', 'floor_id' => 5, 'status' => 1],
            ['room_number' => 'R507', 'floor_id' => 5, 'status' => 1],
            ['room_number' => 'R508', 'floor_id' => 5, 'status' => 1],
            // Add more room details as needed
        ];

        // Insert the room details into the 'rooms' table
        DB::table('rooms')->insert($rooms);
    }
}
