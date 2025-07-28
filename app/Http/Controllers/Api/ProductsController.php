<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Đây là cú pháp Eloquent ORM để eager load (nạp trước) các quan hệ category và brand liên kết với Product.
        return Product::with(['category','brand'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Dữ liệu từ request:', $request->all());

        // Validate the incoming request
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            // Phải đúng form của 1 url
            'img_url' => 'nullable|string|url',  // Validation for img_url
        ]);

        // Create a new product
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'img_url' => $request->img_url,  // Save img_url if provided
        ]);

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['category','brand'])->findOrFail($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "required|string",
            "img_url" => "nullable|string|url",
            "description" => "nullable|string",
            "price" => "required|numeric",
            "category_id" => "required|exists:categories,id",
            "brand_id" => "required|exists:brands,id"
        ]);
        $product = Product::findOrFail($id);

        $product->update([
            "name" => $request->name,
            "img_url" => $request->img_url,
            "description" => $request->description,
            "price" => $request->price,
            "category_id" => $request->category_id,
            "brand_id" => $request->brand_id
        ]);
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findorFail($id);
        $product->delete();
        return response()->json(['messge' => 'Product deleted successfully']);
    }
}
