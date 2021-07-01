<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //fetch product_items by order of product name
    public function index()
    {
        $products = Product::orderby('product_id', 'desc') -> paginate(10);
        return ProductResource::collection($products);
    }

    // add product_item
    public function store(CreateProductRequest $request, Product $product)
    {
        $product = Product::create($request->validated());
        return new ProductResource($product);
    }

    //display a product_item
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    //updating a product_item
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return new ProductResource($product) ;
    }

    //deleting a product_item
    public function destroy(Product $product)
    {
        return $product->delete();
    }

    //
}
