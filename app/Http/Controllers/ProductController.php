<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        /** @var Collection<Product> $products */
        $products = Product::query()
            ->with(['category', 'brand'])
            ->when(request('brands'), function ($query, $brands) {
                $query->whereIn('brand_id', $brands);
            })
            ->when(request('categories'), function ($query, $categories) {
                $query->whereIn('category_id', $categories);
            })
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->paginate(10);

        /** @var Collection<Category> $categories */
        $categories = Category::all();

        /** @var Collection<Brand> $brands */
        $brands = Brand::all();

        return Inertia::render('Admin/Product/Index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'filters' => request()->only(['brands', 'categories', 'search'])
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::create($this->validateProduct($request) + ['user_id' => $request->user()->id]);

        $this->uploadImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validateProduct($request));

        $this->uploadImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    private function validateProduct(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);
    }

    private function uploadImages(Request $request, Product $product)
    {
        if ($request->hasFile('productImages')) {
            foreach ($request->file('productImages') as $image) {
                $path = $image->store('product_images', 'public');

                $product->images()->create([
                    'image' => 'storage/' . $path,
                ]);
            }
        }
    }
}
