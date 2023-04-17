<?php

namespace App\Http\Filters\Search;


use Elastic\ScoutDriverPlus\Builders\BoolQueryBuilder;
use Elastic\ScoutDriverPlus\Exceptions\QueryBuilderValidationException;
use Elastic\ScoutDriverPlus\Support\Query;
use Illuminate\Http\Request;

abstract class SearchableFilter
{
    private Request $request;
    private BoolQueryBuilder $builder;

    public function _construct(BoolQueryBuilder $builder, Request $request): void
    {
        $this->builder=$builder;
        $this->request=$request;
    }

    public function request(): Request
    {
        return $this->request;

    }

    public function apply(): BoolQueryBuilder
    {
        foreach ($this->request->all() as $name => $value) {
            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], array_filter([$value]));
            }
        }

        try {
            $this->builder->buildQuery();
        } catch (QueryBuilderValidationException $e) {
            $this->builder->should(Query::matchAll());
        }

        return $this->builder;
    }

}
