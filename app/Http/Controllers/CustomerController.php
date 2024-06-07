<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Http\Requests\CustomerRequest;
use App\Imports\CustomerImport;
use App\Models\Category;
use App\Models\Language;
use App\Models\Package;
use App\Models\User;
use App\Models\UserCategory;
use App\Models\UserLanguage;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
//use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel;


class CustomerController extends Controller
{
    public function index(Request $request){
        if($request->search){
            $customers = User::where('role', 'user')->where('phone','like', '%'.$request->search.'%')->orWhere('name', 'like', '%'.$request->search.'%')->paginate(5);
        }else{
            $customers = User::where('role', 'user')->paginate(100);
        }
        return view('backend.customer.index', compact('customers'));
    }

    public function create(){
        $languages = Language::all();
        $categories = Category::all();
        $countries = DB::table('countries')->get('*');
        return view('backend.customer.create', compact('languages', 'categories', 'countries'));
    }

    public function store(CustomerRequest $request){
//        dd($request->all());
        $customer = User::create($request->all() +
            [
                'password' => Hash::make('password'),
            ],
        );
        $customer->country = $request->country;
        $customer->state = $request->state;
        $customer->city = $request->city;
        $customer->save();


        if ($request->category_id != null){
            $categories = $request->category_id;
            foreach ($categories as $cat){
                $userCat = new UserCategory();
                $userCat->user_id = $customer->id;
                $userCat->category_id = $cat;
                $userCat->save();
            }
        }

        if($request->language_id != null){
            $languages = $request->language_id;
            foreach($languages as $lang){
                $userLang = new UserLanguage();
                $userLang->user_id = $customer->id;
                $userLang->language_id = $lang;
                $userLang->save();
            }
        }

        $package = Package::first();
        UserPackage::create([
            'user_id' => $customer->id,
            'package_id' => $package->id,
            'start_date' => today()->toDateString(),
            'expiry_date' => today()->addDays($package->duration)->toDateString(),
        ]);

        return redirect('customer');
    }

    public function edit(User $customer){
//        dd($customer->states->name);
        $categories = Category::all();
        $languages = Language::all();
        return view('backend.customer.edit', compact('customer', 'categories', 'languages'));
    }

    public function update(CustomerRequest $request, User $customer){

        $customer->update($request->except(['password', 'languages']));


        if ($request->language_id != null){
            $languages = $request->language_id;
            foreach ($languages as $lang){
                if (!UserLanguage::where(['user_id' => $customer->id, 'language_id' => $lang])->exists()){
                    $userLanguage = new UserLanguage();
                    $userLanguage->user_id = $customer->id;
                    $userLanguage->language_id = $lang;
                    $userLanguage->save();
                }
            }
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

    public function customerExport()
    {
        return Excel::download(new CustomerExport, 'customers.xlsx');
    }

    public function customerDetails(User $customer){
        return view('backend.customer.details', compact('customer'));
    }

}
