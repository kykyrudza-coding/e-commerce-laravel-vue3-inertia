<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $colors = Color::pluck('name')->toArray();

        $ram = [64, 128, 256, 512];

        $names = [
            'iPhone 14', 'Galaxy S23', 'Pixel 7', 'Redmi Note 12', 'iPhone 14 Pro',
            'Galaxy Z Fold 5', 'Pixel 7 Pro', 'Redmi Note 12 Pro', 'iPhone 13', 'Galaxy S22 Ultra',
            'Pixel 6a', 'Redmi 10', 'iPhone 12', 'Galaxy A54', 'OnePlus 11', 'Huawei P60 Pro',
            'Sony Xperia 1 V', 'Motorola Edge 40', 'Asus ROG Phone 7', 'Nothing Phone (2)',
            'Oppo Find X6 Pro', 'Vivo X90 Pro', 'Realme GT 3', 'Honor Magic5 Pro', 'Black Shark 5 Pro',
            'Nokia G60 5G', 'Fairphone 4', 'ZTE Axon 40 Ultra', 'LG Velvet 2 Pro', 'Microsoft Surface Duo 2',
            'iPhone SE (2022)', 'Galaxy M14 5G', 'Poco F5', 'Infinix Zero Ultra', 'Tecno Phantom V Fold',
            'Xiaomi 13 Ultra', 'Google Pixel Fold', 'iPhone 15', 'Galaxy S24', 'Pixel 8', 'Redmi K60 Ultra',
            'iPhone 15 Pro', 'Galaxy A73 5G', 'Pixel 8 Pro', 'Redmi Note 13 Pro', 'iPhone 11 Pro',
            'Galaxy Note 20 Ultra', 'Pixel 5', 'Redmi 9A', 'iPhone XR', 'Galaxy Z Flip 4', 'OnePlus 10 Pro',
            'Huawei Mate 50 Pro', 'Sony Xperia 5 IV', 'Motorola G82', 'Asus Zenfone 9', 'Nothing Phone (1)',
            'Oppo Reno 10 Pro+', 'Vivo Y100', 'Realme Narzo 60', 'Honor X9a', 'Black Shark 4 Pro',
            'Nokia X30 5G', 'Fairphone 5', 'ZTE Blade V40 Pro', 'LG Wing 5G', 'Microsoft Lumia 950 XL',
            'iPhone 15 Pro Max', 'Galaxy S21 FE', 'Poco X5 Pro', 'Infinix Note 30', 'Tecno Camon 20 Pro',
            'Xiaomi 12T Pro', 'Google Pixel 6 Pro', 'iPhone 14 Plus', 'Galaxy Z Fold 4', 'Pixel 4a',
            'Redmi Note 11', 'iPhone 12 Mini', 'Galaxy A13', 'OnePlus Nord 2T', 'Huawei P40 Pro',
            'Sony Xperia 10 V', 'Motorola Edge 30 Fusion', 'Asus ROG Phone 6', 'Oppo A77 5G', 'Vivo T1 5G',
            'Realme 11 Pro+', 'Honor Play 40', 'Black Shark 3', 'Nokia 5.4', 'Fairphone 3', 'ZTE Nubia Red Magic 8 Pro',
            'LG G8 ThinQ', 'Microsoft Surface Duo', 'iPhone 13 Pro Max', 'Galaxy S20 FE', 'Poco M4 Pro',
            'Infinix Zero X Pro', 'Tecno Spark 10 Pro', 'Xiaomi Mi 11 Ultra', 'Google Pixel 4 XL', 'iPhone 11',
            'Galaxy S10+', 'Pixel 3a', 'Redmi 7'
        ];

        $currentIndex = 0;

        foreach (range(1, 100) as $index) {
            $product = Product::create([
                'category_id' => $faker->numberBetween(3, 16),
                'name' => $names[$currentIndex] . ' ' . $faker->randomElement($ram) . 'GB ' . $faker->randomElement($colors),
                'description' => $faker->sentence(50),
                'price' => $faker->randomFloat(0, 1000, 2000),
                'stock' => $faker->numberBetween(10, 50),
                'slug' => $faker->slug,
                'brand_id' => $faker->numberBetween(1, 9),
                'screen_size_id' => $faker->numberBetween(1, 4),
                'screen_type_id' => $faker->numberBetween(1, 5),
                'os_id' => $faker->numberBetween(2, 3),
                'processor_id' => $faker->numberBetween(1, 10),
                'ram_id' => $faker->numberBetween(1, 4),
                'storage_id' => $faker->numberBetween(1, 8),
                'camera_resolution_id' => $faker->numberBetween(1, 5),
                'battery_capacity_id' => $faker->numberBetween(1, 25),
                'color_id' => $faker->numberBetween(1, 11),
                'condition_id' => $faker->numberBetween(1, 3),
            ]);

            $currentIndex++;

            if ($currentIndex >= count($names)) {
                $currentIndex = 0;
            }

            $mainImageIndex = rand(1, 5);

            foreach (range(1, 5) as $imageIndex) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'is_main' => $imageIndex === $mainImageIndex,
                    'image_path' => 'images/products/faker/image' . $imageIndex . '.jpg',
                ]);
            }
        }
    }
}
