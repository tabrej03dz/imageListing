<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
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
        $images = Image::onlyTrashed()->get();
        return view('backend.recycle.index', compact('customers', 'images', 'categories', 'languages', 'packages', 'notes'));
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

    public function clearAllCustomer(){
        $customers = User::onlyTrashed()->get();
        foreach($customers as $customer){
            $customer->forceDelete();
        }
        return back()->with('success', 'Clear all customers successfully');
    }

    public function restoreAllCustomer(){
        $customers = User::onlyTrashed()->get();
        foreach($customers as $customer){
            $customer->restore();
        }

    }

    public function clearAllCategories(){
        $categories = Category::onlyTrashed()->get();
        foreach ($categories as $category){
            $category->forceDelete();
        }
        return back()->with('success', 'Clear All Categories successfully');
    }

    public function restoreAllCategories(){
        $categories = Category::onlyTrashed()->get();
        foreach($categories as $category){
            $category->restore();
        }
        return back()->with('success', 'Restore All Categories successfully');
    }

    public function restoreAllLanguages(){
        $languages = Language::onlyTrashed()->get();
        foreach ($languages as $language){
            $language->restore();
        }
        return back()->with('success', 'Restore languages successfully');
    }

    public function deleteAllLanguages(){
        $languages = Language::onlyTrashed()->get();
        foreach($languages as $language){
            $language->forceDelete();
        }
        return back()->with('success', 'Clear all languages successfully');
    }

    public function restoreAllPackages(){
        $packages = Package::onlyTrashed()->get();
        foreach ($packages as $package){
            $package->restore();
        }
        return back()->with('success', 'Restore all packages successfully');
    }

    public function deleteAllPackages(){
        $packages = Package::onlyTrashed()->get();
        foreach ($packages as $package){
            $package->forceDelete();
        }
        return back()->with('success', 'Clear all packages successfully');
    }

    public function imageDelete($id){
        $image = Image::withTrashed()->find($id);
        if($image->media){
            $filePath = public_path('storage/'. $image->media);
            if(file_exists($filePath)){
                unlink($filePath);
            }
        }
        $image->forceDelete();
        return back()->with('success', 'Image deleted permanently');
    }

    public function imageRestore($id){
        $image = Image::withTrashed()->find($id);
        $image->restore();
        return back()->with('success', 'Image restore successfully');
    }

    public function deleteAllImages(){
        $images = Image::onlyTrashed()->get();
        foreach ($images as $image){
            if($image->media){
                $filePath = public_path('storage/'. $image->media);
                if(file_exists($filePath)){
                    unlink($filePath);
                }
            }
            $image->forceDelete();
        }
        return back()->with('success', 'Deleted permanently');
    }

    public function restoreAllImages(){
        $images = Image::onlyTrashed()->get();
        foreach ($images as $image){
            $image->restore();
        }
        return back()->with('success', 'Restored successfully');
    }
}
