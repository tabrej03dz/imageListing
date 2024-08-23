<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\UserCategory;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('backend.category.index', compact('categories'));
    }

    public function create(){
        $categories = Category::where('category_id', null)->get();
        return view('backend.category.create', compact('categories'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'description' => '',
            'category_id' => '',
        ]);

        Category::create($request->except(['description']) + ['description' => $request->description ?? 'null']);
        return redirect('category')->with('success', 'Category created successfully');
    }

    public function edit(Category $category){
        $categories = Category::where('category_id', null)->get();
        return view('backend.category.edit', compact('categories', 'category'));
    }

    public function update(Category $category, Request $request){
        $request->validate([
            'name' => 'required',
            'description' => '',
            'category_id' => '',
        ]);

        $category->update($request->all());
        return redirect('category')->with('success', 'Category Updated Successfully');
    }

    public function destroy(Category $category){
        $subCats = $category->childrens;
        if ($subCats->count() > 0){
            foreach ($subCats as $cat){
                $cat->delete();
            }
        }
        $category->delete();
        return redirect('category')->with('success', 'Category Deleted Successfully');
    }


    public function customerCategoryDelete($category, $customer){
        $customerCategory = UserCategory::where(['category_id' => $category, 'user_id' => $customer])->delete();
//        dd($customerCategory);
        return redirect()->back();
    }
}
