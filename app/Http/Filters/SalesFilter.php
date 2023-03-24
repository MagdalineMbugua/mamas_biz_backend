<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class SalesFilter extends Filter
{
    public function traderName($value): Builder
    {
        return  $this->builder->where('trader_name', 'like', $value);
    }
    public function salesType($value): Builder
    {
        return $this->builder->where('sales_type', '=', $value);
    }
}
