<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalesRequest;
use App\Models\Sale;


class SalesController extends Controller

{

//fetch sales_items by order of creation date
public function index(CreateSalesRequest $request){
    $sales = Sale::orderby('created_at', 'desc') -> paginate(20);
    return $sales;

}

// add sales_item
public function store(Sale $sale){
  return Sale::create($sale->validated());

}

//display a sales_item
public function show (Sale $sales_id){
    return Sale::findorfail($sales_id);
}

//updating a sales_item
public function update (Sale $sales_id, Sale $sales){
    return Sale::findorfail($sales_id) ->update($sales ->validated());
}

//deleting a sales_item
public function delete(Sale $sales_id){
    return Sale::findorfail($sales_id)->delete;
}


    
}


