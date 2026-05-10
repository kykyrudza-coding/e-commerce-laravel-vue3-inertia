<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            City::class,
            Region::class,
            PostOffice::class,
            ProductSeeder::class,
        ]);
    }
}
