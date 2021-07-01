<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //fetch payments by order of creation date
    public function index()
    {
        $payments = Payment::orderby('created_at', 'desc') -> paginate(10);
        return PaymentResource::collection($payments);
    }

    // add payment_item
    public function store(CreatePaymentRequest $request, Payment $payment)
    {
        $payment = Payment::create($request->validated());
        return new PaymentResource($payment);
    }

    //display a payment_item
    public function show(Payment $payment)
    {
        return new PaymentResource($payment);
    }

    //updating a payment_item
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $payment->update($request ->validated());
        return new PaymentResource($payment);
    }

    //deleting a payment_item
    public function destroy(Payment $payment)
    {
        return $payment->delete();
    }
}
