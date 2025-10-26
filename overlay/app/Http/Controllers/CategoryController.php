<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('user_id',$request->user()->id)->orderBy('name')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255']
        ]);
        $data['user_id'] = $request->user()->id;
        Category::create($data);
        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        abort_if($category->user_id !== auth()->id(), 403);
        return view('categories.edit', ['cat'=>$category]);
    }

    public function update(Request $request, Category $category)
    {
        abort_if($category->user_id !== auth()->id(), 403);
        $data = $request->validate(['name'=>['required','string','max:255']]);
        $category->update($data);
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        abort_if($category->user_id !== auth()->id(), 403);
        $category->delete();
        return redirect()->route('categories.index');
    }
}
