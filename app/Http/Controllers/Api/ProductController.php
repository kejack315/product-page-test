<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $formattedProducts = $this->formatProducts($products);
        return response()->json(['data' => $formattedProducts]);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
        $formattedProduct = $this->formatProduct($product);
        return response()->json(['data' => $formattedProduct], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        // Validation
        // old laravel can't use validate function,
        // $validatedData = $request->validated();
        // $validated = $request->validated();
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'active' => 'boolean',
            'discount.type' => 'required|string|in:percent,amount',
            'discount.amount' => 'required_if:discount.type,percent|numeric|min:0|max:100',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $product = Product::create($request->all());
        $discountData = $request->input('discount');
        ProductDiscount::create([
            'product_id' => $product->id,
            'type' => $discountData['type'],
            'discount' => $discountData['amount'],
        ]);
        if ($request->has('images')) {
        $imagePaths = $request->input('images');
        foreach ($imagePaths as $path) {
            ProductImage::create([
                'product_id' => $product->id,
                'path' => $path,
            ]);
        }}
        $formattedProduct = $this->formatProduct($product);

        return response()->json(['data' => $formattedProduct], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
        // Validation
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'active' => 'boolean',
            'discount.type' => 'required|string|in:percent,amount',
            'discount.amount' => 'required_if:discount.type,percent|numeric|min:0|max:100',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }


        //old laravel can't use validate function
        //      $validatedData = $request->validated();
//        $validated = $request->validated();

        $product->update($request->all());
        if ($request->has('discount')) {
            $discountData = $request->input('discount');
            $discount = ProductDiscount::where('product_id', $product->id)->first();
            if ($discount) {
                $discount->update([
                    'type' => $discountData['type'],
                    'discount' => $discountData['amount'],
                ]);
            }
        }

        if ($request->has('images')) {
            ProductImage::where('product_id', $product->id)->delete();
            $imagePaths = $request->input('images');
            foreach ($imagePaths as $path) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                ]);
            }
        }

        $formattedProduct = $this->formatProduct($product);
        return response()->json(['data' => $formattedProduct], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
        $productId = $product->id;//can use product name as well
        ProductDiscount::where('product_id', $product->id)->delete();
        ProductImage::where('product_id', $product->id)->delete();
        $product->delete();
        // Can keep associated ProductImage and ProductDiscount records here if needed.
        return response()->json(['message' => "product $productId deleted"], Response::HTTP_OK);
    }

    // Helper function to format a single product.
    private function formatProduct($product)
    {
        $images = ProductImage::where('product_id', $product->id)->pluck('path')->toArray();

        // if no discount value，default 100
        $discount = ProductDiscount::where('product_id', $product->id)->first();
        if (!$discount) {
            $discount = new ProductDiscount();
            $discount->discount = 100;
            $discount->type = 'percent';
        }

        $discountedPrice = ($product->price) * ($discount->discount) / 100;

        return [
            'id' => (string)$product->id,
            'name' => $product->name,
            'description' => $product->description,
            'slug' => $product->slug,
            'price' => [
                'full' => $product->price,
                'discounted' => $discountedPrice,
            ],
            'discount' => [
                'type' => $discount->type,
                'amount' => $discount->discount,
            ],
            'images' => $images,
        ];
    }


    // Helper function to format a collection of products.
    private function formatProducts($products)
    {
        return $products->map(function ($product) {
            return $this->formatProduct($product);
        });
    }

}
