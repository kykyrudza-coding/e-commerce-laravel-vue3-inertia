<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProccesorsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('processors')->insert([
            [
                'slug' => 'apple',
                'name' => 'A13 Bionic',
            ],
            [
                'slug' => 'apple',
                'name' => 'A14 Bionic',
            ],
            [
                'slug' => 'apple',
                'name' => 'A15 Bionic',
            ],
            [
                'slug' => 'qualcomm',
                'name' => 'Snapdragon 888',
            ],
            [
                'slug' => 'qualcomm',
                'name' => 'Snapdragon 865',
            ],
            [
                'slug' => 'qualcomm',
                'name' => 'Snapdragon 8 Gen 2',
            ],
            [
                'slug' => 'samsung',
                'name' => 'Exynos 2100',
            ],
            [
                'slug' => 'samsung',
                'name' => 'Exynos 2200',
            ],
            [
                'slug' => 'mediatek',
                'name' => 'Dimensity 1200',
            ],
            [
                'slug' => 'mediatek',
                'name' => 'Dimensity 9000',
            ],
        ]);
    }
}
