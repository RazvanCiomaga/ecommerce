<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['brands', 'categories', 'search']);
        $products = $this->productService->getProducts($filters);

        return Inertia::render('Admin/Product/Index', [
            'products' => $products,
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'filters' => $filters,
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
        return back()->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
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
                $product->images()->create(['image' => 'storage/' . $path]);
            }
        }
    }

    public function destroyImage(ProductImage $image)
    {
        $path = str_replace('storage/', '', $image->image);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
        $image->delete();
        return back()->with('success', 'Image deleted successfully');
    }
}
