<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::query()
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10);

        return Inertia::render('Admin/Category/Index', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request) {
        Category::create($this->validateCategory($request));
        return back()->with('success', 'Category added successfully.');
    }

    public function update(Request $request, Category $category) {
        $category->update($this->validateCategory($request));
        return back()->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category) {
        $category->delete();
        return back()->with('success', 'Category deleted successfully.');
    }

    public function validateCategory($request) {
        return $request->validate([
            'name' => 'required|string|max:255',
        ]);
    }
}
