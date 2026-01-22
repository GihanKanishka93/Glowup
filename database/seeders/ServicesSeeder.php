<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('services')) {
            return;
        }

        // Clear existing services
        DB::table('services')->truncate();

        $services = [
            [
                'name' => 'Hydrafacial',
                'price' => 7500,
                'description' => 'Deep cleanse, exfoliation, hydration; reduces acne, fine lines, dark spots and evens tone.',
            ],
            [
                'name' => 'MDA (Microdermabrasion)',
                'price' => 1500,
                'description' => 'Gentle exfoliation to smooth texture; pricing from LKR 1,500 upwards.',
            ],
            [
                'name' => 'Bridal Package',
                'price' => 18000,
                'description' => 'Comprehensive glow-up program; packages from LKR 18,000 upwards.',
            ],
            [
                'name' => 'Carbon Laser',
                'price' => 12000,
                'description' => 'Laser + carbon peel for pores, texture, and oil control.',
            ],
            [
                'name' => 'Laser Hair Reduction',
                'price' => 5000,
                'description' => 'Permanent hair reduction for all skin types; pricing from LKR 5,000 upwards.',
            ],
            [
                'name' => 'Chemical Peeling',
                'price' => 7000,
                'description' => 'Targets dullness, pigmentation, and texture; from LKR 7,000 upwards.',
            ],
            [
                'name' => 'PRP Face / Hair',
                'price' => 13000,
                'description' => 'Platelet-Rich Plasma to boost collagen and hair growth; from LKR 13,000 upwards.',
            ],
            [
                'name' => 'Wart Removal',
                'price' => 3000,
                'description' => 'Painless wart removal; from LKR 3,000 upwards.',
            ],
            [
                'name' => 'Fat Burn Treatment',
                'price' => 10000,
                'description' => 'Body contouring/per session pricing.',
            ],
            [
                'name' => 'Laser Tattoo Removal',
                'price' => 10000,
                'description' => 'Multi-color tattoo removal; from LKR 10,000 upwards.',
            ],
            [
                'name' => 'Ultrasound Therapies',
                'price' => 0,
                'description' => 'Non-invasive contouring, skin tightening, wart removal; price on consultation.',
            ],
            [
                'name' => 'Microneedling (with/without MDA)',
                'price' => 0,
                'description' => 'Collagen induction for scars, wrinkles, stretch marks; price on consultation.',
            ],
        ];

        DB::table('services')->insert(
            collect($services)->map(function ($service) {
                return [
                    'name' => $service['name'],
                    'price' => $service['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->all()
        );
    }
}
