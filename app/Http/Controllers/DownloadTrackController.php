<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
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

    public function visits(Request $request){

        $visits = Visit::whereDate('created_at', $request->date ?? today())->get();
        return view('backend.visits', compact('visits'));
    }

    public function clearVisits(){
        Visit::where('created_at', '<',  Carbon::now()->subDays(3))->delete();
        return redirect()->back()->with('success', 'Three days older records cleared successfully');
    }

    public function clearDownloads(){
        DownloadTrack::where('updated_at', '<', Carbon::now()->subDays(3))->delete();
        return redirect()->back()->with('success', 'Three days older records cleared successfully');
    }
}
