<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function dashboard(){
        $customers = User::where('role', '!=', 'admin')->get();
        $images = Image::all();
        return view('backend.dashboard', compact('customers', 'images'));
    }

    public function index($number = null){
        if($number){
            $user = User::where('phone', $number)->first();
            if (!$user){
                return view('welcome');
            }
            $images = Image::where('user_id', $user->id)->whereDate('date', '>=', Carbon::now()->subDay(2))->get();
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
}
