<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index() {
        return Inertia::render('Admin/Category/Index', [
            'categories' => Category::paginate(10)
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
