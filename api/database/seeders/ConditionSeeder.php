<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Condition;

class ConditionSeeder extends Seeder
{
    public function run(): void
    {
        $conditions = [
            'New',
            'Used',
            'Refurbished',
        ];

        foreach ($conditions as $conditionName) {
            Condition::firstOrCreate([
                'name' => $conditionName,
            ]);
        }
    }
}
