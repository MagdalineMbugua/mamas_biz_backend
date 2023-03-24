<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class SalesProductController extends Controller
{
    /**
     * add product to sale
     * @param ProductRequest $request
     * @param $saleId
     * @return AnonymousResourceCollection
     */
    public function store(ProductRequest $request, $saleId): AnonymousResourceCollection
    {
        $sale = Sales::find($saleId);
        collect($request->validated()['data'])->each(function ($product) use ($sale){
            $sale->products()->attach([$product['product_id']=> [
                'price'=>$product['price'],
                'quantity'=>$product['quantity']
            ]]);
        });
        return ProductResource::collection($sale->products);
    }

    /**
     * update products under sale
     * @param ProductRequest $request
     * @param $saleId
     * @return ProductResource
     */
    public function update(ProductRequest $request,$saleId): ProductResource
    {
        $sale = Sales::find($saleId);
        collect($request->validated()['data'])->each(function ($product) use ($sale){
            $sale->products()->sync([$product['product_id']=> [
                'price'=>$product['price'],
                'quantity'=>$product['quantity']
            ]]);
        });
        return new ProductResource($sale->products) ;
    }

    /**
     * Delete product under sale
     * @param $saleId
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy($saleId,Product $product): JsonResponse
    {
        $sale = Sales::find($saleId);
        $sale->products()->detach($product->id);
        return response()->json(['message'=>'Successfully Deleted'], Response::HTTP_NO_CONTENT);
    }
}
