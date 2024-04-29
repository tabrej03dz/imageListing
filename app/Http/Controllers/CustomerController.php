<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Imports\CustomerImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Excel;


class CustomerController extends Controller
{
    public function index(){
        $customers = User::where('role', '!=', 'admin')->paginate(5);
//        dd($customers);
        return view('backend.customer.index', compact('customers'));
    }

    public function create(){
        return view('backend.customer.create');
    }

    public function store(CustomerRequest $request){
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
        $customer->update($request->except('password'));

        if($request->password){
            $customer->password = Hash::make($request->password);
            $customer->save();
        }

        return redirect('customer');
    }

    public function customerUpload(){
        return view('backend.customer.upload');
    }

    public function customerImport(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        // Process the uploaded file
        $file = $request->file('file');

        // Resolve an instance of the Excel facade
        $excel = app()->make('excel');

        try {
            // Import customers from the uploaded Excel file
            $result = $excel->import(new CustomerImport, $file);

            // Check if the import was successful
            if ($result) {
                return redirect('customer')->with('success', 'Customers Imported Successfully');
            } else {
                return redirect('customer')->with('error', 'Failed to import customers. Please try again.');
            }
        } catch (ValidationException $e) {
            $failures = $e->failures();
            return redirect('customer')->with('error', 'Validation failed. Please check your Excel file and try again.');
        }
    }

    public function destroy(User $customer){
        foreach ($customer->images as $image){
            if($image->media){
                $filePath = public_path('storage/' . $image->media);
                if(file_exists($filePath)){
                    unlink($filePath);
                }
            }
            $image->delete();
        }
        $customer->delete();
        return redirect('customer')->with('success', 'User deleted successfully');
    }

    public function customerImages(User $customer){
        $images = $customer->images;
        return view('backend.customer.images', compact('images', 'customer'));
    }

}
