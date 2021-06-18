<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
//fetch payments by order of creation date
public function index(){

    $payments = Payment::orderby('created_at', 'desc') -> paginate(10);
    return $payments;

}

// add payment_item
public function store(Payment $payment){
  return Payment::create($payment->validated());

}

//display a payment_item
public function show (Payment $payment_id){
    return Payment::findorfail($payment_id);
}

//updating a payment_item
public function update (Payment $payment_id, Payment $payment){
    return Payment::findorfail($payment_id) ->update($payment ->validated());
}

//deleting a payment_item
public function delete(Payment $payment_id){
    return Payment::findorfail($payment_id)->delete;
}

    //
}
