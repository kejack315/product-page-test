<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $seedProducts = [
            [ 'name' => 'Product 1',
                'description' => "'These low-profile sneakers are your perfect casual wear companion. Featuring a durable rubber outer sole, they'll withstand everything the weather can offer",
                "slug"=> "fall-limited-edition-sneakers",
                'price' => 100,
                'active' => true,],
        ];

        foreach ($seedProducts as $seedProduct) {
            Product::updateOrCreate($seedProduct);
        }
    }
}
