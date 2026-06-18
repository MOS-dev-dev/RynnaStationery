<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    /**
     * Get products with flash sale status
     */
    public function getFlashSaleProducts(int $limit = 4)
    {
        return Cache::remember(
            'flash_sale_products_' . $limit,
            now()->addMinutes(5),
            function () use ($limit) {
                return Product::where('is_flash_sale', true)
                    ->where(function ($query) {
                        $query->whereNull('flash_sale_end')
                            ->orWhere('flash_sale_end', '>', now());
                    })
                    ->orderBy('flash_sale_end', 'asc')
                    ->take($limit)
                    ->get();
            }
        );
    }

    /**
     * Calculate discounted price
     */
    public function calculatePrice(Product $product): float
    {
        if ($product->is_flash_sale && 
            (!$product->flash_sale_end || $product->flash_sale_end > now())) {
            return $product->sale_price ?? $product->price * 0.8;
        }
        
        return $product->price;
    }

    /**
     * Clear product cache
     */
    public function clearCache(): void
    {
        Cache::forget('flash_sale_products_4');
        Cache::forget('flash_sale_products_8');
        Cache::forget('featured_products');
    }

    /**
     * Get featured products
     */
    public function getFeaturedProducts(int $limit = 8)
    {
        return Cache::remember(
            'featured_products_' . $limit,
            now()->addHours(1),
            function () use ($limit) {
                return Product::with('category')
                    ->where('stock', '>', 0)
                    ->orderByDesc('sold_count')
                    ->take($limit)
                    ->get();
            }
        );
    }

    /**
     * Search products
     */
    public function searchProducts(string $query, ?int $categoryId = null)
    {
        $products = Product::with('category')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%");

        if ($categoryId) {
            $products->where('category_id', $categoryId);
        }

        return $products->paginate(12);
    }

    /**
     * Update stock after order
     */
    public function updateStock(int $productId, int $quantity): bool
    {
        $product = Product::find($productId);
        
        if (!$product || $product->stock < $quantity) {
            return false;
        }

        $product->decrement('stock', $quantity);
        $product->increment('sold_count', $quantity);
        
        $this->clearCache();
        
        return true;
    }
}
