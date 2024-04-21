<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function index(Request $request, $number = null){
        if ($request->phone){
            $user = User::where('phone', $request->phone)->first();
            $images = Image::where('user_id', $user->id)->get();
        }else{
            if(auth()->user()->role == 'admin'){
                $images = Image::all();
            }else{
                $images = Image::where('user_id', auth()->user()->id)->get();
            }
        }
        $users = User::all();
        return view('backend.image.index', compact('images', 'users'));
    }
    public function uploadImage(){
        return view('backend.image.upload');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'media.*' => 'required|mimes:jpg,png,jpeg',
        ]);

        foreach ($request->file('media') as $media){

            $image = new Image();
            $image->date = Carbon::today();
            $image->title = $request->title;
            if ($media){
                $fileName = Str::limit(pathinfo($media->getClientOriginalName(), PATHINFO_FILENAME), 10, '') ;
//            dd($fileName);
                $image->user_id = User::where('phone', $fileName)->first()->id;
                $file = $media->store('public/images');
                $image->media = str_replace('public/', '', $file);
            }
            $image->save();
        }

        return redirect('image');
    }

    public function destroy(Image $image){
        $image->delete();
        return redirect()->back();
    }


    public function downloadImage(Image $image){

        try {
            $path = storage_path( 'images\PQeLveFCxaZB0IRmVmBgGfWKlEtHv1Omad3rmipO.jpg');
        dd($path);
            return response()->download($path);
        }catch (\Exception $e){
            abort(404);
        }

    }
}
