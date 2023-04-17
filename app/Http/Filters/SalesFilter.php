<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class SalesFilter extends Filter
{

    public function trader_name ($value): Builder
    {
        return $this->builder->where('trader_name', '=', $value);
    }

    public function trader_phone_number ($value): Builder
    {
        return $this->builder->where('trader_phone_number', '=', $value);
    }

    public function sales_type ($value): Builder
    {
        return $this->builder->where('sales_type', '=', $value);
    }
}
