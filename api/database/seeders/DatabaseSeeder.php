<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BatteryCapacitySeeder::class,
            BrandSeeder::class,
            CameraResolutionSeeder::class,
            CategorySeeder::class,
            City::class,
            ColorSeeder::class,
            ConditionSeeder::class,
            OperationSystemsSeeder::class,
            ProccesorsSeeder::class,
            RamSeeder::class,
            Region::class,
            ScreenTypeSeeder::class,
            SizeSeeder::class,
            StorageSeeder::class,
            PostOffice::class,
            ProductSeeder::class,
        ]);
    }
}
