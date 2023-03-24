<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SalesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'trader_name' => $this->trader_name,
            'trader_phone_number' => $this->trader_phone_number,
            'sales_type' => $this->sales_type,
            'products' => ProductResource::collection($this->whenLoaded('products'))
        ];
    }
}
