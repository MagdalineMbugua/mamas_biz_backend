<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

/**
 * @group Payments
 */
class UserPaymentController extends Controller
{
    /**
     * list user payments
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return Payment::query()
            ->select([
                'payments.*',
            ])->with('sales.products')
            ->join('sales', 'sales.id', 'payments.sales_id')
            ->where('sales.created_by', '=', Auth::id())
            ->paginate();
    }

    /**
     * list specific user payment
     * @param Payment $payment
     * @return PaymentResource
     */
    public function show(Payment $payment): PaymentResource
    {
        return new PaymentResource(tap($payment)->load(['sales', 'sales.products']));
    }
}
