<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use App\Models\UserInformation;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Information;
use App\Http\Requests\InformationRequest;

class InformationController extends Controller
{
    public function index(){
        $informations = Information::all();
        return view('backend.information.index', compact('informations'));
    }

    public function create(){
        return view('backend.information.create');
    }

    public function store(InformationRequest $request){
        $information = Information::create($request->except('image'));
        if($request->file('image')){
            $file = $request->file('image')->store('public');
            $information->image = str_replace('public', '', $file);
            $information->save();
        }
        return redirect('information')->with('success', 'information created successfully');
    }

    public function edit(Information $information){
        return view('backend.information.edit', compact('information'));
    }

    public function update(InformationRequest $request, Information $information){
        $information->update($request->except('image'));
        if($request->file('image')){
            if($information->image){
                unlink('storage/'. $information->image);
            }
            $file = $request->file('image')->store('public');
            $information->image = str_replace('public', '', $file);
            $information->save();
        }
        return redirect('information')->with('success', 'Updated successfully');
    }

    public function delete(Information $information){
        if($information->image){
            unlink('storage/' . $information->image);
        }
        $information->delete();
        return back()->with('success', 'Deleted successfully');
    }

    public function informationSendToUser(Request $request){
        $information = Information::find($request->information_id);
        $request->validate([
            'phone' => 'required_without:status',
            'status' => 'required_without:phone',
        ]);

        if(session('instance_id') != null && session('access_token') != null){

            if ($request->phone){
                $sentIds = $information->userSents->pluck('user_id');
                $users = User::where('phone', 'like', '%'.$request->phone.'%')->whereNotIn('id', $sentIds)->take(1);

                if ($users->isEmpty()){
                    return back()->with('error', 'User not found');
                }
            }else{
                $sentIds = $information->userSents->pluck('user_id');
                if($sentIds->count() == 0){
                    $users = User::where(['status' => $request->status, 'role' => 'user'])->take(1)->get();
                }else{
                    $users = User::where(['status' => $request->status, 'role' => 'user'])->whereNotIn('id', $sentIds)->take(1)->get();
                }
            }
            foreach ($users as $user){
                $phoneNumber = substr($user->phone, 0, 12);
//                $imageUrl = 'https://realvictorygroups.xyz/assets/logo.png';
                $message = str_replace(' ', '+', $information->description);
                $fileName = str_replace(' ', '+', $information->title);
                if ($information->image){
                    $imageUrl = asset('storage/'. $information->image);
                    $apiUrl = 'https://rvgwp.in/api/send?number='.$phoneNumber.'&type=media&message='.$message.'&media_url='.$imageUrl.'&filename='.$fileName.'&instance_id='.session('instance_id').'&access_token='.session('access_token');
                }else{
                    $apiUrl = 'https://rvgwp.in/api/send?number='.$phoneNumber.'&type=text&message='.$message.'&instance_id='.session('instance_id').'&access_token='.session('access_token');
                }
                $client = new Client(['verify' => false]);
                $response = $client->request('GET', $apiUrl);

                $message = json_decode($response->getBody()->getContents());
                if ($message->status == 'success'){
                    UserInformation::create(['user_id' => $user->id, 'information_id' => $information->id]);
                }else{
                    continue;
                }
            }


            return redirect()->back()->with('success', 'Message sent successfully');
        }else{
            return redirect()->back('error', 'Please Set the Instance Id and Access Token');
        }

    }
}
