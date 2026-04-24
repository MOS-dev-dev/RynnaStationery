<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product', 'timelines'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Shipping,Completed,Canceled',
            'payment_status' => 'required|in:pending,paid',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->payment_status = $request->payment_status;
        $order->save();

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    public function storeTimeline(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $order = Order::findOrFail($id);
        $order->timelines()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Đã lưu mốc thời gian giao hàng!');
    }
}
