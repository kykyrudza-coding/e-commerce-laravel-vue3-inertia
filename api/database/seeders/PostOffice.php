<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostOffice extends Seeder
{
    public function run(): void
    {
        $postOffices = [
            ['name' => 'Поштове відділення №1', 'address' => 'вул. Подільська, 1', 'city_id' => 1, 'region_id' => 1],
            ['name' => 'Поштове відділення №2', 'address' => 'вул. Фортечна, 2', 'city_id' => 1, 'region_id' => 1],
            ['name' => 'Поштове відділення №3', 'address' => 'вул. Балашівська, 3', 'city_id' => 1, 'region_id' => 1],
            ['name' => 'Поштове відділення №4', 'address' => 'вул. Новомиколаївська, 4', 'city_id' => 1, 'region_id' => 1],
            ['name' => 'Поштове відділення №5', 'address' => 'вул. Ковалівська, 5', 'city_id' => 1, 'region_id' => 1],
            ['name' => 'Поштове відділення №6', 'address' => 'вул. Катранівська, 6', 'city_id' => 1, 'region_id' => 1],
            ['name' => 'Поштове відділення №7', 'address' => 'вул. Озерна, 7', 'city_id' => 1, 'region_id' => 1],
            ['name' => 'Поштове відділення №8', 'address' => 'вул. Арнаутівська, 8', 'city_id' => 1, 'region_id' => 1],
        ]
        ;

        DB::table('post_office')->insert($postOffices);
    }
}
