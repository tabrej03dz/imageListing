<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Models\User;

class NoteController extends Controller
{
    public function index(){
        $notes = Note::all();
        return view('backend.note.index', compact('notes'));
    }

    public function create(User $user){
//        dd($user);
        return view('backend.note.create', compact('user'));
    }

    public function store(Request $request, User $user){
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        Note::create($request->all() + ['user_id' => $user->id]);
        return redirect('customer/details/'.$user->id)->with('success', 'Note added successfully');
    }


    public function edit(Note $note){
        return view('backend.note.edit', compact('note'));
    }

    public function update(Request $request, Note $note){
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $note->update($request->all());
        return redirect('note')->with('success', 'Note updated successfully');
    }

    public function delete(Note $note){
        $note->delete();
        return back()->with('success', 'Note deleted successfully');
    }
}
