<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DownloadTrack;
use App\Models\Image;
use App\Models\User;
use App\Models\UserPackage;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct(){
        $users = User::where('role', '!=', 'admin')->get();
        foreach ($users as $user){
//            $expiryDate = $user->userPackages->max('expiry_date');
            $expiryDate = $user->userPackages()->orderBy('expiry_date', 'desc')->first()->expiry_date;
            $expiryDate = Carbon::parse($expiryDate);
//            dd($expiryDate->lessThan(Carbon::now()));
            if ($expiryDate->lessThan(Carbon::now())){
                $user->update(['status' => '0']);
            }
        }
    }

    public function dashboard(){
        $customers = User::where('role', 'user')->get();
        $images = Image::all();
        $categories = Category::all();
        $currentYear = Carbon::now()->year;
        $visitCounts = Visit::whereDate('created_at', Carbon::today())->count();
//        $customerData = User::selectRaw('MONTH(created_at) as month, DATE_FORMAT(created_at, "%M") as month_name, COUNT(*) as count')
//            ->whereYear('created_at', $currentYear)
//            ->groupBy('month', 'month_name')
//            ->orderBy('month')
//            ->get();

        $customerData = User::selectRaw('DAY(created_at) as day, DATE_FORMAT(created_at, "%d %M %Y") as day_name, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('day', 'day_name')
            ->orderBy('day')
            ->get();

        $expiringPackages = UserPackage::where('expiry_date', '<', Carbon::today()->addDays(20))->get();
//        dd($expiringPackage);

//        dd($customerData);
        return view('backend.dashboard', compact('customers', 'images', 'customerData', 'categories', 'visitCounts', 'expiringPackages'));
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

}
