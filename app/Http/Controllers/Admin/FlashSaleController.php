<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.flash_sale.index', compact('products'));
    }

    public function toggle(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->is_flash_sale = !$product->is_flash_sale;
        $product->save();

        return back()->with('success', 'Trạng thái Flash Sale của sản phẩm đã được cập nhật.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sale_price' => 'nullable|numeric|min:0',
            'flash_sale_end' => 'nullable|date|after:now',
        ]);

        $product = Product::findOrFail($id);
        $product->sale_price = $request->sale_price;
        $product->flash_sale_end = $request->flash_sale_end;
        $product->save();

        return back()->with('success', 'Thông tin Flash Sale đã được cập nhật.');
    }

    public function active()
    {
        $products = Product::with('category')->where('is_flash_sale', true)->latest()->get();
        return view('admin.flash_sale.active', compact('products'));
    }

    public function batchUpdate(Request $request)
    {
        $request->validate([
            'flash_sale_end' => 'required|date|after:now',
        ]);

        Product::where('is_flash_sale', true)->update([
            'flash_sale_end' => $request->flash_sale_end
        ]);

        return back()->with('success', 'Đã cập nhật thời gian kết thúc cho tất cả sản phẩm Flash Sale.');
    }
}
