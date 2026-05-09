<?php

namespace Database\Seeders;

use App\Models\Ram;
use Illuminate\Database\Seeder;

class RamSeeder extends Seeder
{
    public function run(): void
    {
        $rams = [64, 128, 256, 512];

        foreach ($rams as $item) {
            Ram::firstOrCreate([
                'name' => $item,
            ]);
        }
    }
}
