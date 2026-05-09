<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            'Black',
            'White',
            'Red',
            'Blue',
            'Green',
            'Yellow',
            'Purple',
            'Pink',
            'Gold',
            'Silver',
            'Gray',
        ];

        foreach ($colors as $colorName) {
            Color::firstOrCreate([
                'name' => $colorName,
            ]);
        }
    }
}
