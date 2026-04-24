<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Thông số tổng quan
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'user')->count();
        
        // Doanh thu (Chỉ tính đơn đã hoàn thành)
        $totalRevenue = Order::where('status', 'Completed')->sum('total_price');
        
        // Doanh thu tháng này
        $thisMonthRevenue = Order::where('status', 'Completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');

        // Số lượng sản phẩm đang Flash Sale
        $totalFlashSales = Product::where('is_flash_sale', true)->count();

        // 5 đơn hàng gần đây
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Thống kê danh mục
        $categoryStats = Category::withSum('products', 'stock')
                                 ->withSum('products', 'sold_count')
                                 ->get();
        // Sắp xếp giảm dần theo số lượng đã bán
        $sortedCategories = $categoryStats->sortByDesc('products_sum_sold_count');
        $bestSellingCategory = $sortedCategories->first();

        // Prepare monthly revenue data for current year
        $ordersThisYear = Order::where('status', 'Completed')
            ->whereYear('created_at', Carbon::now()->year)
            ->get();

        $monthlyRevenueDataRaw = array_fill(1, 12, 0);
        foreach ($ordersThisYear as $order) {
            $monthlyRevenueDataRaw[$order->created_at->month] += $order->total_price;
        }
        $chartRevenueData = json_encode(array_values($monthlyRevenueDataRaw));
        $chartRevenueLabels = json_encode([
            'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 
            'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 
            'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ]);

        // Chuẩn bị label và data cho Chart.js
        // Format lại giá trị null -> 0 để render chart ko bị lỗi
        $chartLabels = $categoryStats->pluck('name')->toJson();
        $chartStockData = $categoryStats->pluck('products_sum_stock')->map(function($v){ return (int)$v; })->toJson();
        $chartSoldData = $categoryStats->pluck('products_sum_sold_count')->map(function($v){ return (int)$v; })->toJson();

        return view('admin.dashboard', compact(
            'totalOrders', 
            'totalProducts', 
            'totalUsers', 
            'totalRevenue',
            'thisMonthRevenue',
            'totalFlashSales',
            'recentOrders',
            'categoryStats',
            'bestSellingCategory',
            'chartLabels',
            'chartStockData',
            'chartSoldData',
            'chartRevenueLabels',
            'chartRevenueData'
        ));
    }

    public function export(Request $request)
    {
        $categoryStats = Category::withSum('products', 'stock')
                                 ->withSum('products', 'sold_count')
                                 ->get();

        $view = view('admin.export_inventory', compact('categoryStats'))->render();

        $fileName = 'Bao_cao_ton_kho_thang_' . Carbon::now()->format('m-Y') . '.xls';

        return response($view)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Expires', '0')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'public');
    }

    public function exportRevenue(Request $request)
    {
        $ordersThisYear = Order::where('status', 'Completed')
            ->whereYear('created_at', Carbon::now()->year)
            ->get();

        $monthlyRevenueData = array_fill(1, 12, 0);
        foreach ($ordersThisYear as $order) {
            $monthlyRevenueData[$order->created_at->month] += $order->total_price;
        }

        $view = view('admin.export_revenue', compact('monthlyRevenueData'))->render();

        $fileName = 'Bao_cao_doanh_thu_nam_' . Carbon::now()->year . '.xls';

        return response($view)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Expires', '0')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'public');
    }
}
