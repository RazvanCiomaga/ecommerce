<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        /** @var Collection<Product> $products */
        $products = Product::query()->with(['category', 'brand'])->paginate(10);

        return Inertia::render('Admin/Product/Index', [
            'products' => $products,
        ]);
    }
}
