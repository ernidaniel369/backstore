<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource; 

class ProductController extends Controller
{
    public function getAllProduct()
    {
        $products = Product::all();
        return ProductResource::collection($products); 
    }

    public function createProduct(Request $request)
    {
        $product = Product::create($request->all()); 

        // Handle image association (if applicable)
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/products');
            $image = new Image();
            $image->url = $imagePath;
            $image->product_id = $product->id;
            $image->save();
        }

        return new ProductResource($product); 
    }

    public function getProduct($id)
    {
        $product = Product::with('images')->findOrFail($id); 
        return new ProductResource($product);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->only(['stock'])); 

        return new ProductResource($product);
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->noContent(); 
    }
}