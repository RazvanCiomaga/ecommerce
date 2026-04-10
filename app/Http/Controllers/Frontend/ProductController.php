<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Http\Request;
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
        $filters = $request->only(['brands', 'categories', 'search', 'min_price', 'max_price']);
        $products = $this->productService->getProducts($filters, 6); // Show 6 per page for testing pagination

        $brands = Brand::all();
        $categories = Category::all();

        return Inertia::render('Frontend/Product/Index', [
            'products' => $products,
            'filters' => $filters,
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }
}
