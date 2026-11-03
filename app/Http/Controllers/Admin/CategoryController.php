<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories', [
            'categories' => Category::withCount('jobs')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:80|unique:categories,name']);
        Category::create($data + ['slug' => Str::slug($data['name'])]);

        return back()->with('success', 'Category added.');
    }

    public function destroy(Category $category)
    {
        $category->delete(); // jobs keep existing; category_id becomes null

        return back()->with('success', 'Category removed.');
    }
}
