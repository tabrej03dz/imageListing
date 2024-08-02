<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DownloadTrack;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function imageSearch(Request $request){

        $user = User::where('phone', 'like',  '%'.$request->phone.'%')->first();
        if ($user){
            $images = $user->images;
            return response()->json(['images' => $images], 200);
        }else{
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function imageDownload($id){
        $image = Image::find($id);
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
//        return response()->json(['image' => $image], 200);
    }

    public function addCustomer(Request $request){
        return response()->json([
            'success' => true,
            'message' => 'Customer added successfully',
        ]);
    }

}
