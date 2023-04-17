<?php

namespace App\Http\Filters\Search;

use App\Http\Requests\GetProductsRequest;
use Elastic\ScoutDriverPlus\Builders\BoolQueryBuilder;
use Elastic\ScoutDriverPlus\Support\Query;

class ProductFilter extends SearchableFilter
{
    private BoolQueryBuilder $builder;

    public function __construct(GetProductsRequest $request)
    {
        $this->builder = Query::bool();
        parent::_construct($this->builder, $request);
    }

    public function search($value)
    {
        $this->builder->minimumShouldMatch(1)
            ->should(Query::matchPhrase()->field('product_name')->slop(2)->query($value))
            ->should(Query::match()->field('product_type')->query($value));
    }
}
