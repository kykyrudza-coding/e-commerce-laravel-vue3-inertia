<?php

namespace Database\Seeders;

use App\Models\City as ModelsCity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class City extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['name' => 'Кропивницький'],
        ];

        DB::table('city')->insert($cities);
    }
}
