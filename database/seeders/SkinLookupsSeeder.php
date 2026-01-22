<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkinLookupsSeeder extends Seeder
{
    /**
     * Replace pet categories / breeds with skin-care specific values.
     */
    public function run(): void
    {
        $skinTypes = [
            'Normal',
            'Dry',
            'Oily',
            'Combination',
            'Sensitive',
            'Dehydrated',
            'Mature',
            'Acne-prone',
        ];

        $skinConcerns = [
            'Acne & Blemishes',
            'Hyperpigmentation',
            'Melasma',
            'Post-Inflammatory Marks',
            'Rosacea / Redness',
            'Photoaging & Sun Damage',
            'Fine Lines & Wrinkles',
            'Texture & Enlarged Pores',
            'Dullness',
            'Dehydration',
            'Oil Control / Shine',
            'Scarring',
            'Post-Procedure Care',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Detach lookups from existing records so truncation is safe
        DB::table('pets')->update([
            'pet_category' => null,
            'pet_breed' => null,
        ]);

        DB::table('pet_breeds')->truncate();
        DB::table('pet_categories')->truncate();

        // Insert skin types
        DB::table('pet_categories')->insert(
            collect($skinTypes)->map(fn ($name) => ['name' => $name, 'created_at' => now(), 'updated_at' => now()])->all()
        );

        // Insert skin concerns
        DB::table('pet_breeds')->insert(
            collect($skinConcerns)->map(fn ($name) => ['name' => $name, 'created_at' => now(), 'updated_at' => now()])->all()
        );

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
