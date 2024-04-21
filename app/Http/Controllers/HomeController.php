<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index($number = null){
        if($number){
            $user = User::where('phone', $number)->first();
            if (!$user){
                return view('welcome');
            }
            $images = Image::where('user_id', $user->id)->whereDate('created_at', '>=', Carbon::now()->subDay(2))->get();
            return view('user_image', compact('images'));
        }else{
            return view('welcome');
        }
    }

    public function clearOldImage(){
        Image::whereDate('created_at', '<', Carbon::now()->subDay(3))->delete();
        return redirect('dashboard');

    }
}
