<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

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
            $image->date = $request->date ?? Carbon::today();
            $image->title = $request->title;

            if ($media){
                $fileName = Str::limit(pathinfo($media->getClientOriginalName(), PATHINFO_FILENAME), 10, '') ;
                $user = User::where('phone', 'like', '%'.$fileName.'%')->first();

                if ($user){
                    $image->user_id = $user->id;
                    array_push($uploadSuccess, $media->getClientOriginalName());
                } else {
                    array_push($failed, $media->getClientOriginalName());
                    continue;
                }

                $file = $media->store('public/images');
                $image->media = str_replace('public/', '', $file);

                // Increment the count of successfully uploaded images
                $uploadedImagesCount++;
            }

            $image->save();
        }
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

    public function imageShowByDate($date){
        $images = Image::where('date', $date)->paginate(5);
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
}
