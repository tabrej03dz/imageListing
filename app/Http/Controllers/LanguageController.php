<?php

namespace App\Http\Controllers;

use App\Models\UserLanguage;
use Illuminate\Http\Request;
use App\Models\Language;

class LanguageController extends Controller
{
    public function index(){
        $languages = Language::all();
        return view('backend.language.index', compact('languages'));
    }

    public function create(){
        return view('backend.language.create');
    }

    public function store(Request $request){
        if (!Language::where('name', $request->name)->exists()){
            Language::create($request->all());
        }
        return redirect('language')->with('success', 'Language Created Successfully');
    }

    public function destroy(Language $language){
        $language->delete();
        return redirect('language')->with('success', 'Language Deleted successfully');
    }

    public function customerLanguageDelete($language, $customer){
        UserLanguage::where(['user_id' => $customer, 'language_id' => $language])->delete();
        return redirect()->back()->with('success', 'Removed successfully');
    }
}
