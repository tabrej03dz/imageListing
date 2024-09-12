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
            $file = $request->file('image')->store('public/information');
            $information->image = str_replace('public/', '', $file);
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
            $file = $request->file('image')->store('public/information');
            $information->image = str_replace('public/', '', $file);
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

    public function informationSendToUser(Request $request, Information $information){
        $request->validate([
            'phone' => 'required_without:status',
            'status' => 'required_without:phone',
        ]);

        if(session('instance_id') != null && session('access_token') != null){

            if ($request->phone){
                $users = User::where('phone', 'like', '%'.$request->phone.'%')->get();
            }else{
                $sentIds = $information->userSents->pluck('user_id');
//                dd($sentIds);
                if($sentIds->count() == 0){
                    $users = User::where(['status' => $request->status, 'role' => 'user'])->get();
                }else{
                    $users = User::where(['status' => $request->status, 'role' => 'user'])->whereNotIn('id', $sentIds)->get();
                }
            }
//            dd($users);
            foreach ($users as $user){
                $phoneNumber = substr($user->phone, 0, 12);
                $imageUrl = $information->image ? asset('storage/'. $information->image) : asset('assets/logo.png');
//                $imageUrl = 'https://realvictorygroups.xyz/assets/logo.png';
                $message = str_replace(' ', '+', $information->description);
                $fileName = str_replace(' ', '+', $information->title);

                $client = new Client(['verify' => false]);
                $response = $client->request('GET', 'https://rvgwp.in/api/send?number='.$phoneNumber.'&type=media&message='.$message.'&media_url='.$imageUrl.'&filename='.$fileName.'&instance_id='.session('instance_id').'&access_token='.session('access_token'));

//                $client1 = new Client(['verify' => false]);
//
//                $response = $client1->request('GET', 'https://rvgwp.in/api/send?number='.$phoneNumber.'&type=text&message='.$message.'&instance_id='.session('instance_id').'&access_token='.session('access_token'));
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
