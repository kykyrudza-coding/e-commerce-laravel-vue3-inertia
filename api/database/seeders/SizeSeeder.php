<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            4,
            6.1,
            8,
            12,
        ];

        foreach ($sizes as $item) {
            Size::firstOrCreate([
                'name' => $item,
            ]);
        }
    }
}
