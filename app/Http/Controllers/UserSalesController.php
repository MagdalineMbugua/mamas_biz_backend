<?php

namespace App\Http\Controllers;

use App\Http\Filters\SalesFilter;
use App\Http\Requests\CreateSalesRequest;
use App\Http\Requests\UpdateSalesRequest;
use App\Http\Resources\SalesResource;
use App\Models\Sales;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserSalesController extends Controller
{
    public function index(SalesFilter $filter)
    {
        $usersales = Sales::with('products')
            ->where('created_by', '=', Auth::id())
            ->filter($filter)
            ->orderby('created_at', 'desc')
            ->paginate();
        return SalesResource::collection($usersales);
    }

    public function store(CreateSalesRequest $request)
    {
        return new SalesResource(Sales::create($request->validated()));
    }

    public function show(Sales $sale)
    {
        return new SalesResource($sale);
    }

    public function update(UpdateSalesRequest $request, Sales $sales)
    {
        return new SalesResource(tap($sales)->update($request->validated()));
    }

    public function destroy(Sales $sale)
    {
        $sale->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
