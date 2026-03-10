<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrandController extends Controller
{
    public function index() {
        $brands = Brand::query()
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10);

        return Inertia::render('Admin/Brand/Index', [
            'brands' => $brands
        ]);
    }

    public function store(Request $request) {
        Brand::create($this->validateBrand($request));
        return back()->with('success', 'Brand added successfully.');
    }

    public function update(Request $request, Brand $brand) {
        $brand->update($this->validateBrand($request));
        return back()->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand) {
        $brand->delete();
        return back()->with('success', 'Brand deleted successfully.');
    }

    public function validateBrand($request) {
        return $request->validate([
            'name' => 'required|string|max:255',
        ]);
    }
}
