<?php

namespace App\Http\Filters;

class SalesFilter extends Filter
{
    public function name($value)
    {
        return  $this->builder->where('name', 'like', $value);
    }

    public function status($value)
    {
        return $this->builder->whereIn('status', explode(',', $value));
    }

    public function phone_number($value)
    {
        return $this->builder->where('phone_number', '=', $value);
    }

    public function type($value)
    {
        return $this->builder->where('type', '=', $value);
    }
}
