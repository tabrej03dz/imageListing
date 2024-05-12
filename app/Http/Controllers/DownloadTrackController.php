<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DownloadTrack;
use App\Models\Visit;

class DownloadTrackController extends Controller
{
    public function view(Request $request){
        if($request->date){
            $downloads = DownloadTrack::whereDate('updated_at',$request->date)->get();
        }else{
            $downloads = DownloadTrack::whereDate('updated_at', today())->get();
        }
        return view('backend.downloads', compact('downloads'));
    }

    public function visits(){
        $visits = Visit::all();
        return view('backend.visits', compact('visits'));
    }
}
