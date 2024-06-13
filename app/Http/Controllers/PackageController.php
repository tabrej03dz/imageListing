<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\PackageRequest;


class PackageController extends Controller
{
    public function index(){
        $packages = Package::all();
        return view('backend.package.index', compact('packages'));
    }

    public function create(){
        return view('backend.package.create');
    }

    public function store(PackageRequest $request ){
        Package::create($request->all());
        return redirect('package')->with('success', 'Package Created Successfully');
    }

    public function edit(Package $package){
        return view('backend.package.edit', compact('package'));
    }

    public function update(PackageRequest $request, Package $package){
        $package->update($request->all());
        return redirect('package')->with('success', 'Package Updated Successfully');
    }

    public function destroy(Package $package){
        $package->delete();
        return redirect('package')->with('success', 'Package Deleted Successfully');
    }

    public function customerAssignToPackageForm(User $customer){
        $packages = Package::all();
        return view('backend.package.customerAssignToPackageForm', compact('customer', 'packages'));
    }

    public function customerAssignToPackage(Request $request, User $customer){
        $package = Package::find($request->package_id);
        if(!UserPackage::where(['user_id' => $customer->id, 'package_id' => $package->id])->where('expiry_date', '>', $request->start_date ?? Carbon::today())->exists()){
            $userPackage = UserPackage::create([
                'user_id' => $customer->id,
                'package_id' => $package->id,
                'start_date' => $request->start_date ?? Carbon::today(),
                'expiry_date' => $request->start_date ? Carbon::createFromFormat('Y-m-d', $request->input('start_date'))->addDays($package->duration)->toDateString() : Carbon::today()->addDays($package->duration)->toDateString(),
            ]);
            return redirect('customer')->with('success', 'Assigned successfully');
        }else{
            return redirect()->back()->with('error', 'This package is already assigned to this customer');
        }

    }

    public function packageAssignToCustomerForm(Package $package){
        $customers = User::where('role', '!=', 'admin')->get();
        return view('backend.package.packageAssignToCustomerForm', compact('package','customers'));
    }

    public function packageAssignToCustomer(Request $request, Package $package){
//        $customer = User::find($request->customer_id);
        if (!UserPackage::where(['user_id' => $request->customer_id, 'package_id' => $package->id])->where('expiry_date' , '>', $request->start_date ?? Carbon::today())->exists()){
            $userPackage = UserPackage::create([
                'user_id' => $request->customer_id,
                'package_id' => $package->id,
                'start_date' => $request->start_date ?? Carbon::today(),
                'expiry_date' => $request->start_date ? Carbon::createFromFormat('Y-m-d', $request->input('start_date'))->addDays($package->duration)->toDateString() : Carbon::today()->addDays($package->duration)->toDateString(),
            ]);
            return redirect()->back()->with('success', 'Package assigned to customer successfully');
        }else{
            return redirect()->back()->with('error', 'This package is already assigned to this user');
        }
    }

    public function customerPackageDelete(UserPackage $customerPackage){
        $customerPackage->delete();
        return redirect()->back()->with('success', 'Customer Package deleted successfully');
    }

    public function customerPackageEdit(UserPackage $customerPackage){
        $packages = Package::all();
        return view('backend.package.customerPackageEdit', compact('packages', 'customerPackage'));
    }

    public function customerPackageUpdate(Request $request, UserPackage $customerPackage){
        $customerPackage->update([
            'start_date' => $request->start_date ?? Carbon::today(),
            'expiry_date' => $request->start_date ? Carbon::createFromFormat('Y-m-d', $request->input('start_date'))->addDays($customerPackage->package->duration)->toDateString() : Carbon::today()->addDays($customerPackage->package->duration)->toDateString(),
        ]);

        return redirect('customer/details/'.$customerPackage->user_id)->with('success', 'Updated successfully');
    }

    public function customerPackageStatus(UserPackage $customerPackage){
        if($customerPackage->status == '1'){
            $customerPackage->update(['status' => '0']);
        }else{
            $customerPackage->update(['status' => '1']);
        }
        return back()->with('success', 'Status Changed successfully');
    }

    public function renewPackage(UserPackage $package){
        if($package->expiry_date < Carbon::today()){
            $expiry_date = Carbon::today()->addDays($package->package->duration)->toDateString();
        }else{
            $expiry_date = Carbon::createFromFormat('Y-m-d', $package->expiry_date)->addDays($package->package->duration + 1)->toDateString();
        }
        $package->update(['expiry_date' => $expiry_date]);
        return back()->with('success', 'package renewed successfully');
    }
}
