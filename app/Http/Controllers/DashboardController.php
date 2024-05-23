<?php

namespace App\Http\Controllers;

use App\Models\DownloadTrack;
use App\Models\Image;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
Use App\Models\UserPackage;

class DashboardController extends Controller
{


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
            $randomString .= $characters[rand(0, 15)];
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

    public function packageAssignToAllCustomer(){
//        2024-05-22

        $customers = User::where('role', '!=', 'admin')->get();
        $packageId = Package::first()->id;
        foreach($customers as $customer){
            if(UserPackage::where(['user_id' => $customer->id, 'package_id' => $packageId])->exists()){
                continue;
            }
            UserPackage::create([
                'user_id' => $customer->id,
                'package_id' => $packageId,
                'start_date' => '2024-05-22',
                'expiry_date' => '2025-05-22',
            ]);
            $customer->update(['status' => '1']);
        }
        return redirect('customer')->with('success', 'package assigned successfully to all customer');
    }
}
