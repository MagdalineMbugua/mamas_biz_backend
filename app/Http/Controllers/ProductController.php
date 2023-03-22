<?php

namespace App\Http\Controllers;

use App\Http\Filters\ProductFilter;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Products
 */
class ProductController extends Controller
{
    /**
     * list all products
     * @param ProductFilter $filter
     * @return AnonymousResourceCollection
     */
    public function index(ProductFilter $filter): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::query()->filter($filter)->paginate());
    }

    /**
     * show product item
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }
}
