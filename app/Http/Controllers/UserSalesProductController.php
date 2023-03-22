<?php

namespace App\Http\Controllers;


use App\Http\Filters\SalesFilter;
use App\Http\Requests\CreateSalesProductRequest;
use App\Http\Requests\UpdateSalesProductRequest;
use App\Http\Requests\UpdateSalesRequest;
use App\Http\Resources\SalesResource;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use phpseclib3\Math\BigInteger\Engines\PHP\Reductions\Barrett;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group SalesProducts
 */
class UserSalesProductController extends Controller
{
    /**
     * list sales
     * @param SalesFilter $filter
     * @return AnonymousResourceCollection
     */
    public function index(SalesFilter $filter): AnonymousResourceCollection
    {
        return SalesResource::collection(Sales::with('products')
            ->filter($filter)
            ->createdByUser(Auth::id())
            ->paginate());
    }

    /**
     * Create a sale-product
     * @param CreateSalesProductRequest $request
     * @return SalesResource
     *
     */
    public function store(CreateSalesProductRequest $request): SalesResource
    {

        $sale = Sales::create([
            'sales_type' => $request->input('data.sales_type'),
            'trader_name' => $request->input('data.trader_name'),
            'trader_phone_number' => $request->input('data.trader_phone_number')
        ]);

        $products = $request->input('data.products');
        collect($products)->each(function ($product) use ($sale) {
            $savedProduct = Product::create(Arr::except($product, ['price', 'quantity']));
            $sale->products()->sync([$savedProduct->id => ['price' => $product['price'],
                'quantity' => $product['quantity']]]);
        });

        $sale->payments()->create([
            'amount_paid' => $request->input('data.amount_paid'),
            'next_pay_at' => $request->input('data.next_pay_out') ?? null,
        ]);
        return new SalesResource(tap($sale)->load('products'));
    }


    /**
     * show specific sale
     * @param Sales $sales
     * @return SalesResource
     */
    public function show(Sales $sales): SalesResource
    {
        return new SalesResource(tap($sales)->load('products'));
    }

    /**
     * update sale
     * @param UpdateSalesProductRequest $request
     * @param Sales $sales
     * @return SalesResource
     */
    public function update(UpdateSalesRequest $request, $product_sales): SalesResource
    {
        $sales = Sales::find($product_sales);
        return new SalesResource((tap($sales)->update($request->validated()['data']))->load('products'));
    }

    /**
     *
     * delete sale
     * @param Sales $sales
     * @return JsonResponse
     */
    public function destroy($product_sales): JsonResponse
    {
        $sales = Sales::find($product_sales);
        collect($sales->products)->each(fn($product) => $product->delete());
        $sales->delete();
        return response()->json(['message' => 'Successfully deleted'], Response::HTTP_NO_CONTENT);
    }
}
