<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperationSystemsSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'All',
            'Android',
            'iOS',
        ];

        foreach ($types as $type) {
            DB::table('operating_systems')->insert([
                'name' => $type,
            ]);
        }
    }
}
