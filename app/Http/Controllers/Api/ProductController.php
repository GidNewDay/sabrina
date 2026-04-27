<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
    
        // Фильтрация по категории
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query
                ->latest()
                ->paginate(15)
                ->appends($request->query()); // сохраняет query params в пагинации;
        
        return ProductResource::collection($products);
    }

    public function show($id){
        $product = Product::with('category')->findOrFail($id);

        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request){
        $product = Product::create($request->validated());

        return new ProductResource(
            $product->load('category')
        );
    }

    public function update(UpdateProductRequest $request, $id){
        $product = Product::findOrFail($id);
        $product->update($request->validated());

        return new ProductResource($product->load('category'));
    }

    public function destroy($id){
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
