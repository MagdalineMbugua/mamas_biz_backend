<?php

namespace App\Http\Filters\Search;

use App\Http\Requests\GetSalesRequest;
use Elastic\ScoutDriverPlus\Builders\BoolQueryBuilder;
use Elastic\ScoutDriverPlus\Support\Query;

class SalesFilter extends SearchableFilter
{
    private BoolQueryBuilder $builder;

    public function __construct(GetSalesRequest $request)
    {
        $this->builder = Query::bool();
        parent::_construct($this->builder, $request);
    }

    public function search($value)
    {
        $this->builder->minimumShouldMatch(1)
            ->should(Query::matchPhrase()->field('trader_name')->slop(2)->query($value))
            ->should(Query::matchPhrase()->field('trader_phone_number')->slop(2)->query($value));
    }

    public function trader_name($value)
    {
        $this->builder->minimumShouldMatch(1)
            ->should(Query::matchPhrase()->field('trader_name')->slop(2)->query($value));
    }

    public function sales_type($value)
    {
        $this->builder->filter(Query::term()->field('sales_type')->value($value));
    }

    public function trader_phone_number($value)
    {
        $this->builder->filter(Query::term()->field('trader_phone_number')->value($value));
    }

    public function created_by($value)
    {
        $this->builder->filter(Query::term()->field('created_by')->value($value));
    }

}
