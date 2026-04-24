<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->get();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:vouchers,code|max:50',
            'type' => 'required|in:percent,amount,freeship',
            'discount_value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'is_for_new_user' => 'boolean',
            'min_order_value' => 'required|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['is_for_new_user'] = $request->has('is_for_new_user') ? 1 : 0;
        Voucher::create($data);
        return redirect()->route('admin.vouchers.index')->with('success', 'Mã giảm giá đã được tạo thành công.');
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:vouchers,code,'.$voucher->id,
            'type' => 'required|in:percent,amount,freeship',
            'discount_value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'is_for_new_user' => 'boolean',
            'min_order_value' => 'required|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['is_for_new_user'] = $request->has('is_for_new_user') ? 1 : 0;
        $voucher->update($data);
        return redirect()->route('admin.vouchers.index')->with('success', 'Cập nhật mã giảm giá thành công.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Đã xóa mã giảm giá.');
    }
}
