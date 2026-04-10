<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    /**
     * Get a paginated list of products with optional filters.
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getProducts(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return Product::query()
            ->with(['category', 'brand', 'images'])
            ->when($filters['brands'] ?? null, function ($query, $brands) {
                $query->whereIn('brand_id', $brands);
            })
            ->when($filters['categories'] ?? null, function ($query, $categories) {
                $query->whereIn('category_id', $categories);
            })
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when(isset($filters['min_price']) && $filters['min_price'] !== '', function ($query) use ($filters) {
                // Prices in DB are stored in cents
                $cents = round(floatval($filters['min_price']) * 100);
                $query->where('price', '>=', $cents);
            })
            ->when(isset($filters['max_price']) && $filters['max_price'] !== '', function ($query) use ($filters) {
                // Prices in DB are stored in cents
                $cents = round(floatval($filters['max_price']) * 100);
                $query->where('price', '<=', $cents);
            })
            ->paginate($perPage);
    }
}
