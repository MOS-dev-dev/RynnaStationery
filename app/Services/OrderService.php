<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create order from cart
     */
    public function createOrder(array $data, array $items, ?Voucher $voucher = null): Order
    {
        return DB::transaction(function () use ($data, $items, $voucher) {
            // Calculate totals
            $subtotal = collect($items)->sum(fn($item) => $item['price'] * $item['quantity']);
            $shippingFee = $data['shipping_fee'] ?? 30000;
            $discountAmount = 0;

            // Apply voucher if valid
            if ($voucher && $voucher->isValid($subtotal)) {
                $discountAmount = $voucher->calculateDiscount($subtotal);
            }

            $totalPrice = $subtotal + $shippingFee - $discountAmount;

            // Create order
            $order = Order::create([
                'user_id' => $data['user_id'] ?? null,
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'shipping_address' => $data['shipping_address'],
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'discount_amount' => $discountAmount,
                'voucher_code' => $voucher?->code,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_method' => $data['payment_method'] ?? 'cod',
                'payment_status' => 'pending',
            ]);

            // Create order items
            foreach ($items as $item) {
                $order->orderItems()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update product stock
                $productService = new ProductService();
                $productService->updateStock($item['product_id'], $item['quantity']);
            }

            // Use voucher if applied
            if ($voucher) {
                $voucher->increment('used_count');
            }

            // Create initial timeline entry
            $order->timelines()->create([
                'status' => 'pending',
                'message' => 'Đơn hàng đã được tạo',
            ]);

            return $order;
        });
    }

    /**
     * Update order status
     */
    public function updateStatus(Order $order, string $status): bool
    {
        if (!$this->isValidStatusTransition($order->status, $status)) {
            return false;
        }

        return DB::transaction(function () use ($order, $status) {
            $order->update(['status' => $status]);

            $messages = [
                'pending' => 'Đơn hàng đang chờ xử lý',
                'processing' => 'Đơn hàng đang được chuẩn bị',
                'shipping' => 'Đơn hàng đang được giao',
                'delivered' => 'Đơn hàng đã được giao thành công',
                'cancelled' => 'Đơn hàng đã bị hủy',
            ];

            $order->timelines()->create([
                'status' => $status,
                'message' => $messages[$status] ?? 'Cập nhật trạng thái',
            ]);

            return true;
        });
    }

    /**
     * Check if status transition is valid
     */
    private function isValidStatusTransition(string $from, string $to): bool
    {
        $validTransitions = [
            'pending' => ['processing', 'cancelled'],
            'processing' => ['shipping', 'cancelled'],
            'shipping' => ['delivered', 'cancelled'],
            'delivered' => [],
            'cancelled' => [],
        ];

        return in_array($to, $validTransitions[$from] ?? []);
    }

    /**
     * Get orders by status
     */
    public function getOrdersByStatus(string $status, int $perPage = 15)
    {
        return Order::with(['user', 'orderItems.product'])
            ->where('status', $status)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    /**
     * Get revenue statistics
     */
    public function getRevenueStats(string $period = '30 days'): array
    {
        $startDate = now()->subDays(explode(' ', $period)[0]);

        $stats = Order::where('status', 'delivered')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as revenue, COUNT(*) as order_count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'total_revenue' => $stats->sum('revenue'),
            'total_orders' => $stats->sum('order_count'),
            'daily_stats' => $stats,
        ];
    }
}
