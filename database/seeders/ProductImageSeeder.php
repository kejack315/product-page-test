<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $seedProductImages = [
            'image-path-1.png',
            'image-path-2.png',
            'image-path-3.png',
            'image-path-4.png',
        ];

        foreach ($seedProductImages as $imagePath) {
            ProductImage::updateOrCreate([
                'product_id' => 1, // 关联到产品的ID，确保与正确的产品相关联
                'path' => $imagePath,
            ]);
        }
    }
}
