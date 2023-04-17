<?php

namespace App\Http\Controllers;

use App\Http\Filters\Search\SalesFilter;
use App\Http\Resources\SalesResource;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SaleSearchController extends Controller
{
    /**
     * @param SalesFilter $filter
     * @return AnonymousResourceCollection
     */
    public function __invoke(SalesFilter $filter): AnonymousResourceCollection
    {
       return  SalesResource::collection(Sales::searchQuery($filter->apply())
            ->load(['products'])
            ->paginate(15)
            ->onlyModels());
    }
}
