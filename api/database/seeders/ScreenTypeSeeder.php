<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScreenTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'LCD',
            'OLED',
            'AMOLED',
            'TFT',
            'Retina',
            ];

        foreach ($types as $type) {
            DB::table('screen_types')->insert([
                'name' => $type,
            ]);
        }
    }
}
