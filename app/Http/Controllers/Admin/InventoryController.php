<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::withSum('productImports', 'quantity')
            ->orderBy('stock', 'asc')
            ->get();
            
        return view('admin.inventory.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'import_price' => 'nullable|numeric|min:0',
            'note' => 'nullable|string|max:255'
        ]);

        DB::transaction(function () use ($request) {
            // Lưu phiếu nhập
            ProductImport::create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'import_price' => $request->import_price,
                'note' => $request->note
            ]);

            // Cộng dồn tồn kho
            $product = Product::find($request->product_id);
            $product->stock += $request->quantity;
            $product->save();
        });

        return redirect()->route('admin.inventory.index')->with('success', 'Đã nhập hàng thành công!');
    }
}
