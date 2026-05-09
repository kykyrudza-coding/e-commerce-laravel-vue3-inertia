<?php

namespace Database\Seeders;

use App\Models\Size;
use App\Models\Storage;
use Illuminate\Database\Seeder;

class StorageSeeder extends Seeder
{
    public function run(): void
    {
        $storages = [
            4,
            8,
            12,
            24,
            32,
            48,
            96,
            128,
        ];

        foreach ($storages as $item) {
            Storage::firstOrCreate([
                'name' => $item,
            ]);
        }
    }
}
