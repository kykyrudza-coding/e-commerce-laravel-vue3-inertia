<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Region extends Seeder
{
    public function run(): void
    {
        $regions = [
            ['name' => 'Подільський', 'city_id' => 1],
            ['name' => 'Фортечний', 'city_id' => 1],
        ];

        DB::table('region')->insert($regions);
    }
}
