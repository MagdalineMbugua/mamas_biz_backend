<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalesRequest;
use App\Http\Requests\UpdateSalesRequest;
use App\Http\Resources\SalesResource;
use App\Models\Sale;

class SalesController extends Controller
{

//fetch sales_items by order of creation date
    public function index()
    {
        $sales = Sale::orderby('created_at', 'desc') -> paginate(20);
        return SalesResource::collection($sales);
    }

    // add sales_item
    public function store(CreateSalesRequest $request)
    {
        $sales=Sale::create($request->validated());
        return new SalesResource($sales);
    }

    //display a sales_item
    public function show(Sale $sale)
    {
        return new SalesResource($sale);
    }

    //updating a sales_item
    public function update(UpdateSalesRequest $request, Sale $sale)
    {
        
        $sale->update($request ->validated());
        return new SalesResource($sale);
    }

    //deleting a sales_item
    public function destroy(Sale $sale)
    {
        return $sale->delete();
    }
}
