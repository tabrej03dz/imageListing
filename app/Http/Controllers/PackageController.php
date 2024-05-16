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
        $userPackage = UserPackage::create([
            'user_id' => $customer->id,
            'package_id' => $package->id,
            'start_date' => $request->start_date ?? Carbon::today(),
            'expiry_date' => $request->start_date ? Carbon::createFromFormat('Y-m-d', $request->input('start_date'))->addDays($package->duration)->toDateString() :  Carbon::today()->addDays($package->duration)->toDateString(),
        ]);

        return redirect('customer')->with('success', 'Assigned successfully');
    }

    public function packageAssignToCustomerForm(Package $package){
        $customers = User::where('role', '!=', 'admin')->get();
        return view('backend.package.packageAssignToCustomerForm', compact('package','customers'));
    }

    public function packageAssignToCustomer(Request $request, Package $package){

    }
}