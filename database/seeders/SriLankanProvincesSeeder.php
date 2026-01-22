<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SriLankanProvincesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            [
                'name_en' => 'Western Province',
                'name_si' => 'වෙස්ටර්න් පළාත',
                'name_ta' => 'மேல் மாகாணம்'
            ],
            [
                'name_en' => 'Central Province',
                'name_si' => 'මධ්‍යම පළාත',
                'name_ta' => 'மத்திய மாகாணம்'
            ],
            [
                'name_en' => 'Southern Province',
                'name_si' => 'දකුණු පළාත',
                'name_ta' => 'தெற்கு மாகாணம்'
            ],
            [
                'name_en' => 'Northern Province',
                'name_si' => 'උතුරු පළාත',
                'name_ta' => 'வட மாகாணம்'
            ],
            [
                'name_en' => 'Eastern Province',
                'name_si' => 'නැගෙනහිර පළාත',
                'name_ta' => 'கிழக்கு மாகாணம்'
            ],
            [
                'name_en' => 'North Western Province',
                'name_si' => 'උතුරු-තඹ පළාත',
                'name_ta' => 'வட-மேற்கு மாகாணம்'
            ],
            [
                'name_en' => 'North Central Province',
                'name_si' => 'උතුරු-මධ්‍යම පළාත',
                'name_ta' => 'வட-மத்திய மாகாணம்'
            ],
            [
                'name_en' => 'Uva Province',
                'name_si' => 'ඌව පළාත',
                'name_ta' => 'உவா மாகாணம்'
            ],
            [
                'name_en' => 'Sabaragamuwa Province',
                'name_si' => 'සබරගමුව පළාත',
                'name_ta' => 'சபரகமுவா மாகாணம்'
            ],
        ];

        foreach ($provinces as $province) {
            DB::table('provinces')->insert($province);
        }
    }
    
}
