<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Phones' => 'phones',
            'Tables' => 'tables',
        ];

        foreach ($categories as $categoryName => $categorySlug) {
            $category = Category::firstOrCreate(
                ['slug' => $categorySlug],
                ['name' => $categoryName, 'parent_id' => null]
            );
            $parentCategoryIds[$categorySlug] = $category->id;
        }

        $phones = [
            'Apple' => 'apple-phones',
            'Samsung' => 'samsung-phones',
            'Xiaomi' => 'xiaomi-phones',
            'Sony' => 'sony-phones',
            'LG' => 'lg-phones',
            'Huawei' => 'huawei-phones',
            'Asus' => 'asus-phones',
            'Lenovo' => 'lenovo-phones',
        ];

        foreach ($phones as $brandName => $brandSlug) {
            Category::firstOrCreate(
                ['slug' => $brandSlug],
                ['name' => $brandName, 'parent_id' => $parentCategoryIds['phones']]
            );
        }

        $tablet = [
            'Apple' => 'apple-tables',
            'Samsung' => 'samsung-tables',
            'Xiaomi' => 'xiaomi-tables',
            'Oppo' => 'oppo-tables',
            'Huawei' => 'huawei-tables',
            'Lenovo' => 'lenovo-tables',
        ];

        foreach ($tablet as $brandName => $brandSlug) {
            Category::firstOrCreate(
                ['slug' => $brandSlug],
                ['name' => $brandName, 'parent_id' => $parentCategoryIds['tables']]
            );
        }
    }
}
