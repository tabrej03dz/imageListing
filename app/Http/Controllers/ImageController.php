<?php

namespace App\Http\Controllers;

use App\Jobs\SendImageJob;
use App\Models\FailedCustomer;
use App\Models\Image;
use App\Models\User;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;


class ImageController extends Controller
{
    public function index(Request $request, $number = null){
        if ($request->phone){
            $user = User::where('phone', $request->phone)->first();
            $images = Image::where('user_id', $user->id)->get();
            $imagesByDate = $images->groupBy(function ($image) {
                // Extract the date from the created_at timestamp using Carbon
                return Carbon::parse($image->date)->format('Y-m-d');
            });
        }else{
            if(auth()->user()->role == 'admin'){
                $images = Image::all();
                $imagesByDate = $images->groupBy(function ($image) {
                    // Extract the date from the created_at timestamp using Carbon
                    return Carbon::parse($image->date)->format('Y-m-d');
                });
            }else{
                $images = Image::where('user_id', auth()->user()->id)->get();
                $imagesByDate = $images->groupBy(function ($image) {
                    // Extract the date from the created_at timestamp using Carbon
                    return Carbon::parse($image->date)->format('Y-m-d');
                });
            }
        }
        $users = User::all();
        return view('backend.image.index', compact('images', 'users', 'imagesByDate'));
    }
    public function uploadImage(){
        return view('backend.image.upload');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'date' => 'date|nullable',
            'media.*' => '',
        ]);
        $failed = [];
        $uploadSuccess = [];
        $uploadedImagesCount = 0;
        foreach ($request->file('media') as $media){
            $image = new Image();
            $image->date = $request->date ?? Carbon::tomorrow();
            $image->title = $request->title;
            if ($media){
                $fileName = Str::limit(pathinfo($media->getClientOriginalName(), PATHINFO_FILENAME), 10, '') ;
                $user = User::where('phone', 'like', '%'.$fileName.'%')->first();
                if ($user){
                    $image->user_id = $user->id;
                    array_push($uploadSuccess, $media->getClientOriginalName());
                } else {
                    array_push($failed, $fileName);
                    continue;
                }
                $file = $media->store('public/images');
                $image->media = str_replace('public/', '', $file);
                // Increment the count of successfully uploaded images
                $uploadedImagesCount++;
            }
            $image->save();
        }
        $collection = new Collection($failed);
        foreach ($collection as $customer){
            FailedCustomer::create([
                'phone' => $customer,
            ]);
        }
//        Session::put('failedUserCollection', $collection);
        $storedImagesCount = count($request->file('media')) - count($failed);
        return redirect()->back()->with('failedMsg', 'Images Failed to upload')->with('failed', $failed)->with('successMsg', $storedImagesCount . ' images uploaded successfully')->with('uploadSuccess', $uploadSuccess);
    }


    public function destroy(Image $image){
        if($image->media){
            $filePath = public_path('storage/'. $image->media);
            if(file_exists($filePath)){
                unlink($filePath);
            }
        }
        $image->delete();
        return redirect()->back()->with('success', 'Image deleted successfully');
    }

    public function imageShowByDate($date, Request $request){
        if($request->phone){
            $customer = User::where('phone', $request->phone)->first();
            $images = Image::where('date', $date)->where('user_id', $customer->id)->paginate(5);
//            dd($images);
        }else{
            $images = Image::where('date', $date)->paginate(5);
        }
        return view('imagesByDate', compact('images', 'date'));
    }

    public function imageDeleteByDate($date){
        $images = Image::where('date', $date)->get();
        foreach ($images as $image){
            if($image->media){
                $filePath = public_path('storage/'. $image->media);
                if(file_exists($filePath)){
                    unlink($filePath);
                }
            }
            $image->delete();
        }
        return redirect()->back()->with('success', 'Images Delete successfully');
    }

    public function sendImage($date){
//        if(session('instance_id') && session('access_token')){
//            $images = Image::where('date', $date)->get();
//            foreach ($images as $image){
//                if ($image->user->status == '1' && $image->sent == '0'){
//                    $phoneNumber = substr($image->user->phone, -10);
////                    $imageUrl = asset('storage/'. $image->media);
//                    $imageUrl = 'https://post.realvictorygroups.com/storage/images/Xq48aK6uuGnLBshswVrzDc4gT3RPla5Rczz2wSEd.png';
//                    $message = str_replace(' ', '+', $image->title);
//                    $fileName = str_replace(' ', '+', $image->title);
//
//                    $client = new Client(['verify' => false]);
//                    $response = $client->request('GET', 'https://rvgwp.in/api/send?number=91'.$phoneNumber.'&type=media&message='.$message.'&media_url='.$imageUrl.'&filename='.$fileName.'&instance_id='.session('instance_id').'&access_token='.session('access_token'));
//                    $message = $response->getBody()->getContents();
//                    if(json_decode($message)->status == 'error'){
//                        return redirect()->back()->with('error', $message);
//                    }
//                    $image->sent = '1';
//                    $image->save();
//                }
//            }
//            return redirect()->back()->with('success', 'Images send successfully');
//        }else{
//            return redirect()->back('error', 'Please Set the Instance Id and Access Token');
//        }

        SendImageJob::dispatch($date);


    }

    public function singleImageSend(Image $image){
        if($image->user->status == '1' && $image->sent == '0'){

            $phoneNumber = substr($image->user->phone, -10);
            $imageUrl = asset('storage/'. $image->media);
            //$imageUrl = 'https://realvictorygroups.com/wp-content/uploads/2024/04/5102941_2691166-e1712569043142-1024x906.jpg';
            $message = str_replace(' ', '+', $image->title);
            $fileName = str_replace(' ', '+', $image->title);

            $client = new Client(['verify' => false]);
            $response = $client->request('GET', 'https://rvgwp.in/api/send?number=91'.$phoneNumber.'&type=media&message='.$message.'&media_url='.$imageUrl.'&filename='.$fileName.'&instance_id='.session('instance_id').'&access_token='.session('access_token'));
            $message = $response->getBody()->getContents();
            if(json_decode($message)->status == 'error'){
                return redirect()->back()->with('error', $message);
            }else{
                $image->sent = '1';
                $image->save();
                return redirect()->back()->with('success', 'Image Send Successfully');
            }
        }else{
            return redirect()->back()->with('error', 'Not an active user!');
        }
    }
}
