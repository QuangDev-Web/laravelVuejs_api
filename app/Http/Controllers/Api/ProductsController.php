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
        return Product::with(['category','brand'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "img_url" => "nullable|string|url",
            "description" => "nullable|string",
            "price" => "required|numberic",
            "category_id" => "required|exists:categories,id",
            "brand_id" => "required|exists:brands,id"
        ]);
        $product = Product::create([
            "name" => $request->name,
            "img_url" => $request->img_url,
            "description" => $request->description,
            "price" => $request->price,
            "category_id" => $request->category_id,
            "brand_id" => $request->brand_id
        ]);
        return response()->json($product,201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['caterory','brand'])->findOrFail($id);
        return response().json($product);
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
            "price" => "required|numberic",
            "category_id" => "required|exists:categories,id",
            "brand_id" => "required|exists:brand,id"
        ]);
        $product = Product::findOrFailt($id);

        $product->update([
            "name" => $request->name,
            "img_url" => $request->img_url,
            "description" => $request->description,
            "price" => $request->price,
            "category_id" => $request->category_id,
            "brand_id" => $request->brand_id
        ]);
        return response().json($product);
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
