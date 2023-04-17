<?php

namespace App\Http\Controllers;

use App\Http\Filters\Search\ProductFilter;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductSearchController extends Controller
{
    /**
     * @param ProductFilter $filter
     * @return AnonymousResourceCollection
     */
   public function __invoke(ProductFilter $filter): AnonymousResourceCollection
   {
      return ProductResource::collection(  Product::searchQuery($filter->apply())
           ->paginate(15)
           ->onlyModels());
   }
}
