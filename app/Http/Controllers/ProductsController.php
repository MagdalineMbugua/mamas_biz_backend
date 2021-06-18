<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
//fetch product_items by order of product name
public function index(){

    $products = Product::orderby('product_name', 'desc') -> paginate(10);
    return $products;

}

// add product_item
public function store(Product $product){
  return Product::create($product->validated());

}

//display a product_item
public function show (Product $product_id){
    return Product::findorfail($product_id);
}

//updating a product_item
public function update (Product $product_id, Product $product){
    return Product::findorfail($product_id) ->update($product ->validated());
}

//deleting a product_item
public function delete(Product $product_id){
    return Product::findorfail($product_id)->delete;
}

    //
}
