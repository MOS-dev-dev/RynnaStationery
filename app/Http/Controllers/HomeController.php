<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $flashSaleProducts = Product::where('is_flash_sale', true)
            ->where(function($query) {
                $query->whereNull('flash_sale_end')
                      ->orWhere('flash_sale_end', '>', now());
            })
            ->latest()->take(4)->get();
            
        $products = Product::with('category')->latest()->take(8)->get();
        
        // Lấy thời gian kết thúc xa nhất của các sản phẩm flash sale hiện tại
        $flashSaleEndTime = $flashSaleProducts->max('flash_sale_end') ?? Carbon::now()->addDay()->toDateTimeString();
        
        return view('welcome', compact('flashSaleProducts', 'products', 'flashSaleEndTime'));
    }

    public function flashSale()
    {
        $flashSaleProducts = Product::where('is_flash_sale', true)
            ->where(function($query) {
                $query->whereNull('flash_sale_end')
                      ->orWhere('flash_sale_end', '>', now());
            })
            ->latest()->paginate(12)->appends(request()->query());
            
        $flashSaleEndTime = Product::where('is_flash_sale', true)->max('flash_sale_end') ?? Carbon::now()->addDay()->toDateTimeString();

        return view('flash_sale', compact('flashSaleProducts', 'flashSaleEndTime'));
    }

    public function products(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->appends(request()->query());
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['category'])->findOrFail($id);
        
        $hasPurchased = false;
        if (auth()->check()) {
            $hasPurchased = Order::where('user_id', auth()->id())
                ->where('status', 'Completed')
                ->whereHas('orderItems', function ($q) use ($id) {
                    $q->where('product_id', $id);
                })->exists();
        }

        return view('products.show', compact('product', 'hasPurchased'));
    }
}
