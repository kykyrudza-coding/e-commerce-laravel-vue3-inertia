<?php

namespace Database\Seeders;

use App\Models\CameraResolution;
use Illuminate\Database\Seeder;

class CameraResolutionSeeder extends Seeder
{
    public function run(): void
    {
        $resolutions = [
            8,
            12,
            24,
            48,
            96,
        ];

        foreach ($resolutions as $item) {
            CameraResolution::firstOrCreate([
                'name' => $item,
            ]);
        }
    }
}
