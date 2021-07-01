<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalesProductRequest;
use App\Http\Requests\UpdateSalesProductRequest;
use App\Http\Resources\SalesProductResource;
use App\Models\Sale_Product;
use Illuminate\Http\Request;

class SalesProductController extends Controller
{   //get sale_product_item
    public function index()
    {
        $sales_product = Sale_Product::orderby('sales_id', 'desc') -> paginate(20);
        return SalesProductResource::collection($sales_product);
    }

    // add sales_product_item
    public function store(CreateSalesProductRequest $request)
    {
        $sales_product=Sale_Product::create($request->validated());
        return new SalesProductResource($sales_product);
    }

    //display a sales_product_item
    public function show(Sale_Product $sales_product)
    {
        return new SalesProductResource($sales_product);
    }

    //updating a sales_product_item
    public function update(UpdateSalesProductRequest $request, Sale_Product $sales_product)
    {
        $sales_product->update($request ->validated());
        return new SalesProductResource($sales_product);
    }

    //deleting a sales_product_item
    public function destroy(Sale_Product $sales_product)
    {
        return $sales_product->delete();
    }
}
