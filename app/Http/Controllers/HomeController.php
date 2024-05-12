<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DownloadTrack;
use App\Models\Image;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        $categories = Category::all();
        $currentYear = Carbon::now()->year;
        $visitCounts = Visit::whereDate('created_at', Carbon::today())->count();
        $customerData = User::selectRaw('MONTH(created_at) as month, DATE_FORMAT(created_at, "%M") as month_name, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month', 'month_name')
            ->orderBy('month')
            ->get();
        return view('backend.dashboard', compact('customers', 'images', 'customerData', 'categories', 'visitCounts'));
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
        $images = Image::whereDate('date', '<', Carbon::now()->subDay(2))->get();
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
            $images = Image::where('user_id', $user->id)->whereDate('date', '>=', Carbon::now()->subDay(2))->orderBy('date', 'desc')->get();
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



    public static function generateRandomHex()
    {
        $characters = '0123456789abcdef';
        $randomString = '';

        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }


    public function userImageDownload(Image $image){
        if ($image->user->status == '0'){
            return redirect('/')->with('error', 'Inactive User');
        }
        $path = Storage::disk('public')->path($image->media);
        $extension = pathinfo($image->media, PATHINFO_EXTENSION);

        $downloadtrack = DownloadTrack::where(['user_id' => $image->user->id, 'image_id' => $image->id])->first();
        if($downloadtrack){
            $downloadtrack->update(['download_count' => $downloadtrack->download_count + 1]);
        }else{
            DownloadTrack::create([
                'user_id' => $image->user->id,
                'image_id' => $image->id,
            ]);
        }
        $image->user->download_count = $image->user->download_count + 1;
        $image->user->save();
        return response()->download($path, $image->title.'.'.$extension);
    }

}
