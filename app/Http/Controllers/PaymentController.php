<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPackage;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function paymentAdd(UserPackage $customerPackage){
        return view('backend.payment.add_payment')->with('customerPackage', $customerPackage);
    }

    public function makePayment(Request $request,UserPackage $customerPackage){
        Payment::create(
            ['user_package_id' => $customerPackage->id] + $request->all()
        );
        return redirect()->route('customer.details', ['customer' => $customerPackage->customer->id])->with('success', 'Payment Added Successfully');
    }
}
