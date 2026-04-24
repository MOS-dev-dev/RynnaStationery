<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with('orderItems.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cod,qr_code',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Tính toán phí vận chuyển và áp dụng voucher nếu có
        $shippingFee = 30000;
        $discountAmount = 0;
        $shippingDiscount = 0;

        if (session()->has('voucher')) {
            $voucher = session('voucher');
            $voucherId = data_get($voucher, 'id');

            $dbVoucher = \App\Models\Voucher::find($voucherId);
            if ($dbVoucher) {
                $dbVoucher->used_count += 1;
                $dbVoucher->save();
            }

            $vType = data_get($voucher, 'type', 'percent');
            $vValue = data_get($voucher, 'discount_value', 0);
            $vMax = data_get($voucher, 'max_discount', 0);

            if ($vType == 'percent') {
                $d = ($total * $vValue) / 100;
                if ($vMax > 0 && $d > $vMax) $d = $vMax;
                $discountAmount = $d;
            } elseif ($vType == 'amount') {
                $discountAmount = $vValue;
            } elseif ($vType == 'freeship') {
                $d = $vValue;
                if ($vMax > 0 && $d > $vMax) $d = $vMax;
                $shippingDiscount = min($shippingFee, $d);
            }
        }

        $finalTotal = $total + $shippingFee - $discountAmount - $shippingDiscount;
        if ($finalTotal < 0) $finalTotal = 0;

        $voucherCode = session()->has('voucher') ? session('voucher')['code'] : null;

        // Tạo Order với đầy đủ thông tin
        $order = Order::create([
            'user_id' => Auth::id(),
            'subtotal' => $total,
            'shipping_fee' => $shippingFee,
            'discount_amount' => $discountAmount + $shippingDiscount,
            'voucher_code' => $voucherCode,
            'total_price' => $finalTotal,
            'status' => 'Pending',
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
        ]);

        // Tạo mốc hành trình đầu tiên
        $order->timelines()->create([
            'title' => 'Đơn hàng đã được đặt',
            'description' => 'Đơn hàng đang chờ cửa hàng xác nhận.',
        ]);

        // Tạo OrderItems và trừ Tồn Kho
        foreach($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);

            // Trừ tồn kho và tăng lượt bán
            $product = Product::find($id);
            if($product) {
                $product->stock -= $item['quantity'];
                $product->sold_count = ($product->sold_count ?? 0) + $item['quantity'];
                $product->save();
            }
        }

        // Xóa giỏ hàng và voucher
        session()->forget('cart');
        session()->forget('voucher');

        if ($request->payment_method === 'qr_code') {
            return redirect()->route('orders.payment', $order->id)->with('success', 'Bạn đã đặt hàng thành công! Vui lòng thanh toán qua QR Code để hoàn tất mụa sắm.');
        }

        return redirect()->route('orders.show', $order->id)->with('success', 'Bạn đã đặt hàng thành công! Chúng tôi sẽ liên hệ sớm nhất qua số điện thoại ' . $request->customer_phone);
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())->with(['orderItems.product', 'timelines'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function payment($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        if ($order->payment_method !== 'qr_code') {
            return redirect()->route('orders.show', $order->id);
        }

        return view('orders.payment', compact('order'));
    }
}
