<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product_name'=> $this->product_name,
            'product_type'=> $this->product_type,
            'uom'=>$this->uom,
            'quantity'=> $this->whenLoaded('sales',function (){
                return $this->pivot->quantity;
            }),
            'price'=> $this->whenPivotLoaded('sales-products',function (){
                return $this->pivot->price;
            })
        ];
    }
}
