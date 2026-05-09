<?php

namespace Database\Seeders;

use App\Models\BatteryCapacity;
use Illuminate\Database\Seeder;

class BatteryCapacitySeeder extends Seeder
{
    public function run(): void
    {
        $capacity = [
            1000,
            1200,
            1400,
            1600,
            1800,
            2000,
            2200,
            2400,
            2600,
            2800,
            3000,
            3200,
            3400,
            3600,
            3800,
            4000,
            4200,
            4400,
            4600,
            4800,
            5000,
            5200,
            5400,
            5600,
            5800,
        ];

        foreach ($capacity as $item) {
            BatteryCapacity::firstOrCreate([
                'battery_capacity' => $item,
            ]);
        }
    }
}
