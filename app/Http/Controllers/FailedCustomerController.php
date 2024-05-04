<?php

namespace App\Http\Controllers;

use App\Models\FailedCustomer;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class FailedCustomerController extends Controller
{
    public function allFailedCustomer(){
        $customers = FailedCustomer::paginate(5);
        return view('backend.failedCustomer.index', compact('customers'));
    }

    public function add($phone, FailedCustomer $customer){
        $user = User::create([
            'name' => $phone,
            'email' => $phone.'@gmail.com',
            'password' => Hash::make('password'),
            'phone' => $phone,
        ]);
        if ($user){
            $customer->delete();
        }
        return redirect()->back()->with('success', 'Customer added successfully');
    }

    public function remove(FailedCustomer $customer){
        $customer->delete();
        return redirect()->back()->with('success', 'Removed Successfully');
    }
}
