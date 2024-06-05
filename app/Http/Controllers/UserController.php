<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = User::where('role', 'designer')->orWhere('role', 'calling')->get();
//        dd($users);
        return view('backend.user.index', compact('users'));
    }

    public function create(){
        return view('backend.user.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'role' => 'required',
        ]);

        $user = User::create($request->all() + ['password' => Hash::make('password')]);
        if($request->file('profile_photo')){
            $profilePhoto = $request->file('profile_photo')->store('public/profile');
            $user->update(['profile_photo' => str_replace('public/', '', $profilePhoto)]);
        }
        return redirect('user')->with('success', 'Created Successfully');
    }

    public function edit(User $user){
        return view('backend.user.edit', compact('user'));
    }

    public function update(Request $request, User $user){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'role' => 'required',
            'password' => 'string|min:8|nullable',
            'confirm_password' => 'same:password|nullable',
        ]);
        $user->update($request->except('password'));
        if ($request->password){
            $user->update(['password' => Hash::make('password')]);
        }
        if ($request->file('profile_photo')){
            if($user->profile_photo){
                unlink('storage/'. $user->profile_photo);
            }
            $profilePhoto = $request->file('profile_photo')->store('public/profile');
            $user->update(['profile_photo' => str_replace('public/', '', $profilePhoto)]);
        }

        return redirect('user')->with('success', 'Updated successfully');
    }

    public function delete(User $user){
        if($user->profile_photo){
            unlink('storage/'. $user->profile_photo);
        }
        $user->delete();
        return back()->with('success', 'Deleted successfully');
    }
}
