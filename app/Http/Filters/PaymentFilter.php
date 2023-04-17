<?php

namespace App\Http\Filters;

class PaymentFilter extends Filter
{
    public function next_pay_at($value)
    {
        $this->builder->whereDate('next_pay_at', '=', $value);
    }
}
