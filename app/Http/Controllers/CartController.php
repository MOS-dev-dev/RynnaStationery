<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->sale_price ?: $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        session()->flash('show_cart_drawer', true);
        return redirect()->back();
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
        }
        session()->flash('show_cart_drawer', true);
        return redirect()->back();
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
        session()->flash('show_cart_drawer', true);
        return redirect()->back();
    }

    public function applyVoucher(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $voucher = \App\Models\Voucher::where('code', $request->code)->first();

        if (!$voucher) {
            return redirect()->back()->with('error', 'Mã giảm giá không tồn tại!');
        }

        if ($voucher->expires_at && \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($voucher->expires_at))) {
            return redirect()->back()->with('error', 'Mã giảm giá đã hết hạn!');
        }

        if ($voucher->usage_limit && $voucher->used_count >= $voucher->usage_limit) {
            return redirect()->back()->with('error', 'Mã giảm giá đã hết lượt sử dụng!');
        }

        // Check if cart total >= min_order_value
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        if ($total < $voucher->min_order_value) {
            return redirect()->back()->with('error', 'Đơn hàng chưa đạt yêu cầu tối thiểu ('.number_format($voucher->min_order_value).' đ) để áp dụng mã này!');
        }

        if ($voucher->is_for_new_user) {
            if (!\Illuminate\Support\Facades\Auth::check()) {
                return redirect()->back()->with('error', 'Mã đặc quyền này dành cho Tân thủ, vui lòng đăng nhập để sử dụng!');
            }
            $userId = \Illuminate\Support\Facades\Auth::id();
            $orderCount = \App\Models\Order::where('user_id', $userId)->count();
            if ($orderCount > 0) {
                return redirect()->back()->with('error', 'Mã này chỉ dành cho khách hàng chưa từng mua hàng trên hệ thống!');
            }
        }

        session()->put('voucher', [
            'id' => $voucher->id,
            'code' => $voucher->code,
            'type' => $voucher->type,
            'discount_value' => $voucher->discount_value,
            'max_discount' => $voucher->max_discount,
            'min_order_value' => $voucher->min_order_value,
        ]);
        return redirect()->route('cart.index')->with('success', 'Đã áp dụng mã giảm giá thành công!');
    }

    public function removeVoucher()
    {
        session()->forget('voucher');
        return redirect()->route('cart.index')->with('success', 'Đã hủy mã giảm giá!');
    }
}
