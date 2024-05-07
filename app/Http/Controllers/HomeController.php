<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function __construct(){
        $checkExpiredUsers = User::whereDate('expiry_date', '<', now())->get();
        foreach ($checkExpiredUsers as $user){
            $user->update(['status' => '0']);
        }
    }


    public function dashboard(){
        $customers = User::where('role', '!=', 'admin')->get();
        $images = Image::all();
        $currentYear = Carbon::now()->year;
        $customerData = User::selectRaw('MONTH(created_at) as month, DATE_FORMAT(created_at, "%M") as month_name, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month', 'month_name')
            ->orderBy('month')
            ->get();
        return view('backend.dashboard', compact('customers', 'images', 'customerData'));
    }

    public function index($number = null){
        if($number){
            $user = User::where('phone', $number)->first();
            if (!$user){
                return view('welcome');
            }
            $images = Image::where('user_id', $user->id)->whereDate('date', '>=', Carbon::now()->subDay(2))->orderBy('date','desc')->get();
            return view('user_image', compact('images'));
        }else{
            return view('welcome');
        }
    }

    public function clearOldImage(){
        $images = Image::whereDate('date', '<', Carbon::now()->subDay(3))->get();
        foreach ($images as $image){
            if($image->media){
                $filePath = public_path('storage/' . $image->media);
                if(file_exists($filePath)){
                    unlink($filePath);
                }
            }
            $image->delete();
        }
        return redirect('dashboard');
    }

    public function profile(){
        return view('backend.profile');
    }

    public function imgSearch(Request $request){
        $request->validate([
            'search' => 'required',
        ]);
        $user = User::where('phone', 'like', '%'.$request->search.'%')->first();
        if($user){
            $images = Image::where('user_id', $user->id)->whereDate('date', '>=', Carbon::now()->subDay(2))->get();
        }else{
            return redirect()->back()->with('error', 'User not found! Please enter registered number!');
        }
        return view('user_image', compact('images'));
    }

    public function setKeys(Request $request){
        session(['instance_id' => $request->instance_id]);
        session(['access_token' => $request->access_token]);
        return redirect()->back()->with('success', 'Instance Id and Access Token set successfully');
    }


}
