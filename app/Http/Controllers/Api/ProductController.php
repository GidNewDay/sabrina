<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        return ProductResource::collection(
            $query->latest()->paginate(10)
        );
    }

    public function show($id){
        $product = Product::with('category')->findOrFail($id);

        return new ProductResource($product);
    }
}
