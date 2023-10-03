<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductDiscount;
use Illuminate\Database\Seeder;


class ProductDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        $product = Product::find(1);

        if ($product) {
            $discountData = [
                'type' => 'percent',
                'discount' => 50,
            ];

            $discount = productDiscount::updateOrCreate(
                ['product_id' => $product->id],
                $discountData
            );
        }
    }
}
