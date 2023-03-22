<?php

namespace App\Http\Filters;



use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends Filter
{
    public function productType($value): Builder
    {
        return $this->builder->where('product_type', '=', $value);
    }

    public function productName($value): Builder
    {
        return $this->builder->where('product_name', '=', $value);
    }
}
