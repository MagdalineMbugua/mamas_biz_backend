<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\Sales;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Payments
 */
class SalesPaymentController extends Controller
{

    public function index($salesId): array
    {
        $salesPayment = Sales::query()
            ->createdByUser(Auth::id())
            ->select([
                'sales.id',
                'sales.trader_name',
                'sales.trader_phone_number',
                DB::raw('sales_products.price*sales_products.quantity as product_amount'),
            ])
            ->with('payments')
            ->join('sales_products', 'sales.id', 'sales_products.sales_id')
            ->where('sales.id', '=', $salesId)
            ->get()
            ->groupBy([
                'sales.id'
            ])
            ->map(function ($salesPayment) {

                return [
                    'trader_name' => $salesPayment->pluck('trader_name')->first(),
                    'trader_phone_number' => $salesPayment->pluck('trader_phone_number')->first(),
                    'sales_amount' => $salesPayment->sum('product_amount'),
                    'amount_paid' => array_sum($salesPayment->pluck('payments.*.amount_paid')->first()),
                    'next_pay_at'=>Arr::last($salesPayment->pluck('payments.*.next_pay_at')->first()),
                    'balance' => $salesPayment->sum('product_amount') - array_sum($salesPayment->pluck('payments.*.amount_paid')->first()),
                ];
            })->values();

        return [
            'data' => $salesPayment,
        ];
    }

    /**
     * @param CreatePaymentRequest $request
     * @param $salesId
     * @return PaymentResource
     */
    public function store(CreatePaymentRequest $request, $salesId): PaymentResource
    {
        $sales=Sales::findOrFail($salesId);
        $sales->payments()->create($request->validated());
        return new PaymentResource($sales->payments);
    }


    /**
     * @param $sales
     * @param $payment
     * @return PaymentResource
     */
    public function show($sales, $payment): PaymentResource
    {
        return new PaymentResource(Payment::findOrFail($payment));
    }

    /**
     * @param UpdatePaymentRequest $request
     * @param Sales $sales
     * @param Payment $payment
     * @return PaymentResource
     */
    public function update(UpdatePaymentRequest $request,  $salesId,  $paymentId): PaymentResource
    {
        $payment=Payment::findOrFail($paymentId);
        $payment->update($request->validated());
        return new PaymentResource($payment);
    }

    /**
     * @param Sales $sales
     * @param Payment $payment
     * @return JsonResponse
     */
    public function destroy( $salesId,  $paymentId): JsonResponse
    {
        $payment=Payment::findOrFail($paymentId);
        $payment->delete();
        return response()->json(['message=>Successfully deleted'], Response::HTTP_NO_CONTENT);
    }
}
