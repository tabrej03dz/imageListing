<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use App\Models\Note;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RecycleController extends Controller
{
    public function index(){
        $customers = User::onlyTrashed()->get();
        $categories = Category::onlyTrashed()->get();
        $languages = Language::onlyTrashed()->get();
        $packages = Package::onlyTrashed()->get();
        $notes = Note::onlyTrashed()->get();
        return view('backend.recycle.index', compact('customers', 'categories', 'languages', 'packages', 'notes'));
    }

    public function customerRestore($id){
        $customer = User::withTrashed()->find($id);
        $customer->restore();
        return back()->with('success', 'restored successfully');
    }

    public function customerDestroy($id){
        $customer = User::withTrashed()->find($id);
        $customer->forceDelete();
        return back()->with('success', 'Deleted Successfully');
    }

    public function categoryRestore($id){
        $category = Category::withTrashed()->find($id);
        $category->restore();
        return back()->with('success', 'Restored successfully');
    }

    public function categoryDelete($id){
        $category = Category::withTrashed()->find($id);
        $category->forceDelete();
        return back()->with('success', 'Category Deleted successfully');
    }

    public function languageRestore($id){
        $language = Language::withTrashed()->find($id);
        $language->restore();
        return back()->with('success', 'Language Restored successfully');
    }

    public function languageDelete($id){
        $language = Language::whitTrashed()->find($id);
        $language->forceDelete();
        return back()->with('success', 'Language deleted for permanently');
    }

    public function packageDelete($id){
        $package = Package::withTrashed()->find($id);
        $package->forceDelete();
        return back()->with('success', 'Package Deleted Permanently');
    }

    public function packageRestore($id){
        $package = Package::withTrashed()->find($id);
        $package->restore();
        return back()->with('success', 'Package restored successfully');
    }

    public function noteDelete($id){
        $note = Note::withTrashed()->find($id);
        $note->forceDelete();
        return back()->with('success', 'Note deleted permanently');
    }

    public function noteRestore($id){
        $note = Note::withTrashed()->find($id);
        $note->restore();
        return back()->with('success', 'Note restored successfully');
    }
}
