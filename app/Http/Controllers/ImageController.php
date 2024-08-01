<?php

namespace App\Http\Controllers;

use App\Jobs\SendImageJob;
use App\Models\FailedCustomer;
use App\Models\FailedCustomerImage;
use App\Models\Image;
use App\Models\MultipleSend;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;


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
            if(auth()->user()->role == 'admin' || auth()->user()->role == 'designer'){
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
//        $users = User::all();
        $setting = Setting::first();
        return view('backend.image.index', compact('images', 'setting', 'imagesByDate'));
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
            $fileName = substr(str_replace(' ', '', pathinfo($media->getClientOriginalName(), PATHINFO_FILENAME)), 0,12);
            $user = User::where('phone', 'like', '%'.$fileName.'%')->first();
            if ($user){
                $multipleSend = MultipleSend::find(1);
                if ($multipleSend->multiple_send_in_single_day == '0'){
                    if (Image::where(['date' => $request->date ?? Carbon::tomorrow(), 'user_id' => $user->id])->exists()){
                        continue;
                    }
                }

                if($request->replace != null){
                    $oldImage = Image::where(['user_id' => $user->id, 'date' => $request->date ?? Carbon::tomorrow()])->first();
                    if($oldImage->media){
                        $filePath = public_path('storage/'. $oldImage->media);
                        if(file_exists($filePath)){
                            unlink($filePath);
                        }
                    }
                    $file = $media->store('public/images');
                    $oldImage->update([
                        'date' => $request->date ?? Carbon::tomorrow(),
                        'title' => $request->title ?? $oldImage->title,
                        'media' => str_replace('public/', '', $file),
                    ]);
                    $uploadedImagesCount++;
                }else{
                    $image = new Image();
                    $image->date = $request->date ?? Carbon::tomorrow();
                    $image->title = $request->title;
                    $image->user_id = $user->id;
                    array_push($uploadSuccess, $media->getClientOriginalName());

                    $file = $media->store('public/images');
                    $image->media = str_replace('public/', '', $file);
                    // Increment the count of successfully uploaded images
                    $uploadedImagesCount++;
                    $image->save();
                }
            } else {
                $failedCustomer = FailedCustomer::where('phone', $fileName)->first();
                if (!$failedCustomer){
                    $failedCustomer = FailedCustomer::create(['phone' => $fileName]);
                }
                $failedCustomerImage = new FailedCustomerImage();
                $failedCustomerImage->title = $request->title;
                $failedCustomerImage->date = $request->date ?? Carbon::tomorrow();
                $failedCustomerImage->failed_customer_id = $failedCustomer->id;

                $file = $media->store('public/images');
                $failedCustomerImage->media = str_replace('public/', '', $file);
                $failedCustomerImage->save();
                array_push($failed, $fileName);
                continue;
            }
//            $image->save();
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
            $image->delete();
        }
        return redirect()->back()->with('success', 'Images Delete successfully');
    }

    public function sendImage($date){
        if(session('instance_id') != null && session('access_token') != null){
            $images = Image::where(['date' => $date, 'sent' => '0'])->take(30)->get();
            foreach ($images as $image){
                if ($image->user->status == '1'){
                    $phoneNumber = substr(str_replace(' ', '', $image->user->phone), 0, 12);
//                    $imageUrl = asset('storage/'. $image->media);
                    $imageUrl = 'https://post.realvictorygroups.com/public/assets/logo.png';
                    $message = str_replace(' ', '+', $image->title);
                    $fileName = str_replace(' ', '+', $image->title);

                    $client = new Client(['verify' => false]);
                    $response = $client->request('GET', 'https://rvgwp.in/api/send?number='.$phoneNumber.'&type=media&message='.$message.'&media_url='.$imageUrl.'&filename='.$fileName.'&instance_id='.session('instance_id').'&access_token='.session('access_token'));
                    $message = json_decode($response->getBody()->getContents());
                    $image->sent = '1';
                    if($message->status == 'error'){
                        $image->sent = '0';
                        $image->save();
                    }

                    $image->save();
                }else{
                    continue;
                }
            }
            return redirect()->back()->with('success', 'Images send successfully');
        }else{
            return redirect()->back('error', 'Please Set the Instance Id and Access Token');
        }
//        SendImageJob::dispatch($date);
    }

    public function singleImageSend(Image $image){
        if($image->user->status == '1' && $image->sent == '0'){
//            $phoneNumber = substr($image->user->phone, -10);
            $phoneNumber = substr($image->user->phone, 0, 12);
            $imageUrl = asset('storage/'. $image->media);
            //$imageUrl = 'https://realvictorygroups.xyz/storage/images/deipEEisit9ziAmq7SnsdmLSVg9upJBXwlCcs7Pz.jpg';
            $message = str_replace(' ', '+', $image->title);
            $fileName = str_replace(' ', '+', $image->title);

            $client = new Client(['verify' => false]);
            $response = $client->request('GET', 'https://rvgwp.in/api/send?number='.$phoneNumber.'&type=media&message='.$message.'&media_url='.$imageUrl.'&filename='.$fileName.'&instance_id='.session('instance_id').'&access_token='.session('access_token'));
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

    public function enableMultipleSend(){
        $enable = MultipleSend::all();
        if ($enable->count() == 0){
            MultipleSend::create(['multiple_send_in_single_day' => 1]);
        }else{

            $enable = MultipleSend::find(1);
            if ($enable->multiple_send_in_single_day == '1'){
                $enable->multiple_send_in_single_day = '0';
            } else{
                $enable->multiple_send_in_single_day = '1';
            }
            $enable->save();
        }

        return redirect()->back()->with('success', $enable->multiple_send_in_single_day == 1 ? 'enabled':'disabled'. ' successfully');
    }

    public function showAllImages(){
        $setting = Setting::first();
        if($setting->show_all_images == '0'){
            $setting->show_all_images = '1';
        }else{
            $setting->show_all_images = '0';
        }
        $setting->save();
        return back()->with('success', 'changes successfully');
    }

    public function sendImageWithAjax($date){
        if(session('instance_id') != null && session('access_token') != null){
            $image = Image::where(['date' => $date, 'sent' => '0'])->first();

            $phoneNumber = substr(str_replace(' ', '', $image->user->phone), 0, 12);
//                    $imageUrl = asset('storage/'. $image->media);
            $imageUrl = 'https://post.realvictorygroups.com/public/assets/logo.png';
            $message = str_replace(' ', '+', $image->title);
            $fileName = str_replace(' ', '+', $image->title);

            $client = new Client(['verify' => false]);
            $response = $client->request('GET', 'https://rvgwp.in/api/send?number='.$phoneNumber.'&type=media&message='.$message.'&media_url='.$imageUrl.'&filename='.$fileName.'&instance_id='.session('instance_id').'&access_token='.session('access_token'));
            $message = json_decode($response->getBody()->getContents());
            $image->sent = '1';
            if($message->status == 'error'){
                $image->sent = '0';
                $image->save();
            }
            $image->save();
            $count = Image::where(['date' => $date, 'sent' => '1'])->count();
            return response()->json(['success' => true, 'message' => 'Images sent successfully', 'count' => $count]);

        }else{
            return response()->json(['success' => false, 'message' => 'Please set the Instance Id and Access Token']);
        }
    }

    public function sentCount($date){
        $notSent = Image::where(['date' => $date, 'sent' => '0'])->count();
        return response()->json(['success' => true, 'count' => $notSent]);
    }

}
