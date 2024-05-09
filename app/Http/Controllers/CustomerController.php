<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Imports\CustomerImport;
use App\Models\Category;
use App\Models\User;
use App\Models\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Excel;


class CustomerController extends Controller
{
    public function index(Request $request){
        if($request->search){
            $customers = User::where('role', '!=', 'admin')->where('phone','like', '%'.$request->search.'%')->orWhere('name', 'like', '%'.$request->search.'%')->paginate(5);
        }else{
            $customers = User::where('role', '!=', 'admin')->paginate(5);
        }
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
        $categories = Category::all();
        return view('backend.customer.edit', compact('customer', 'categories'));
    }

    public function update(CustomerRequest $request, User $customer){

        $customer->update($request->except(['password', 'languages']));


        if ($request->languages != null){
            if ($customer->languages != null){

                $languages = json_decode($customer->languages);
                $customer->languages = json_encode(array_merge($languages, $request->languages));
            }else{
                $customer->languages = json_encode($request->languages);

            }
            $customer->save();
        }

        if($request->password){
            $customer->password = Hash::make($request->password);
            $customer->save();
        }

        if ($request->category_id != null){
            $categories = $request->category_id;
            foreach ($categories as $cat){
                $userCategory = new UserCategory();
                $userCategory->user_id = $customer->id;
                $userCategory->category_id = $cat;
                $userCategory->save();
            }
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

    public function status(User $customer){
        if($customer->status == '1'){
            $customer->status = '0';
        }else{
            $customer->status = '1';
        }
        $customer->save();
        return redirect('customer')->with('success', 'Customer Status changed successfully');
    }

    public function customerLanguageRemove(User $customer, $index){
        $languages = json_decode($customer->languages);
        unset($languages[$index]);
        $customer->languages = json_encode($languages);
        $customer->save();
        return redirect()->back();
    }

}
