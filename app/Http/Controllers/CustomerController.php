<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class CustomerController extends Controller
{
    public function index(){
        $customers = User::where('role', '!=', 'admin')->get();
//        dd($customers);
        return view('backend.customer.index', compact('customers'));
    }

    public function create(){
        return view('backend.customer.create');
    }

    public function store(CustomerRequest $request){

//        dd($request->all());
        User::create($request->all() +
            [
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
        );

        return redirect('customer');
    }

    public function edit(User $customer){
//        dd($customer);
        return view('backend.customer.edit', compact('customer'));
    }

    public function update(CustomerRequest $request, User $customer){

        $customer->update(
        $request->all() +
                [
                    'password' => Hash::make($request->password),
                ]
        );
        return redirect('customer');
    }

}
