<?php

namespace App\Http\Controllers;

use App\Models\FailedCustomer;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\FailedCustomerImage;


class FailedCustomerController extends Controller
{
    public function allFailedCustomer(){
        $customers = FailedCustomer::paginate(5);
        return view('backend.failedCustomer.index', compact('customers'));
    }

    public function add($id){
        $failedCustomer = FailedCustomer::find($id);
        $user = User::create([
            'name' => $failedCustomer->phone,
            'email' => $failedCustomer->phone.'@gmail.com',
            'password' => Hash::make('password'),
            'phone' => $failedCustomer->phone,
        ]);
        foreach($failedCustomer->images as $failedImage){
            $image = new Image();
            $image->title = $failedImage->title;
            $image->date = $failedImage->date;
            $image->media = $failedImage->media;
            $image->user_id = $user->id;
            $image->save();

            $failedImage->delete();
        }

        if ($user){
            $failedCustomer->delete();
        }

        return redirect()->back()->with('success', 'Customer added successfully');
    }

    public function remove(FailedCustomer $customer){
        foreach ($customer->images as $image){
            if($image->media){
                $filePath = public_path('storage/'. $image->media);
                if(file_exists($filePath)){
                    unlink($filePath);
                }
            }
            $image->delete();
        }
        $customer->delete();
        return redirect()->back()->with('success', 'Removed Successfully');
    }

    public function removeAll(){
        $failedCustomerImages = FailedCustomerImage::all();
        foreach($failedCustomerImages as $image){
            $filePath = public_path('storage/'. $image->media);
            if (file_exists($filePath)){
                unlink($filePath);
            }
            $image->delete();
        }
        $failedCustomers = FailedCustomer::all();
        foreach($failedCustomers as $customer){
            $customer->delete();
        }
        return redirect()->back()->with('success', 'Removed All Successfully');
    }
}
