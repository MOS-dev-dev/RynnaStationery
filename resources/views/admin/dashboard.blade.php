<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-earth-900 tracking-tight flex items-center">
            <span class="w-2 h-8 bg-sepia-500 rounded-full mr-4"></span>
            {{ __('Báo cáo tổng quan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-beige-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            <!-- Thẻ Thống kê -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Tổng Doanh Thu -->
                <div class="card-beige p-8 bg-earth-900 text-white shadow-xl shadow-earth-900/20">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-earth-800 rounded-2xl text-sepia-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold text-earth-500 uppercase tracking-widest">Live</span>
                    </div>
                    <div class="text-3xl font-bold tracking-tighter mb-2">{{ number_format($totalRevenue) }}đ</div>
                    <div class="text-[10px] text-earth-400 font-bold uppercase tracking-[0.2em]">Tổng doanh thu</div>
                    <div class="mt-6 pt-6 border-t border-earth-800 flex justify-between items-center">
                        <span class="text-[9px] text-earth-500 font-bold uppercase">Tháng này</span>
                        <span class="text-xs font-bold text-sepia-400">{{ number_format($thisMonthRevenue) }}đ</span>
                    </div>
                </div>

                <!-- Tổng Đơn Hàng -->
                <div class="card-beige p-8 bg-white border border-beige-200">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-beige-50 rounded-2xl text-sepia-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold tracking-tighter mb-2 text-earth-900">{{ $totalOrders }}</div>
                    <div class="text-[10px] text-earth-300 font-bold uppercase tracking-[0.2em]">Tổng đơn đặt hàng</div>
                </div>

                <!-- Tổng Sản Phẩm -->
                <div class="card-beige p-8 bg-white border border-beige-200">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-beige-50 rounded-2xl text-earth-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold tracking-tighter mb-2 text-earth-900">{{ $totalProducts }}</div>
                    <div class="text-[10px] text-earth-300 font-bold uppercase tracking-[0.2em]">Sản phẩm hiện có</div>
                </div>

                <!-- Tổng Khách Hàng -->
                <div class="card-beige p-8 bg-white border border-beige-200">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-beige-50 rounded-2xl text-earth-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold tracking-tighter mb-2 text-earth-900">{{ $totalUsers }}</div>
                    <div class="text-[10px] text-earth-300 font-bold uppercase tracking-[0.2em]">Khách hàng đăng ký</div>
                </div>

                <!-- Đang Flash Sale -->
                <div class="card-beige p-8 bg-red-50 border border-red-100 shadow-lg shadow-red-500/5">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-white rounded-2xl text-red-500 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold text-red-400 animate-pulse uppercase tracking-widest">Active</span>
                    </div>
                    <div class="text-3xl font-bold tracking-tighter mb-2 text-red-600">{{ $totalFlashSales }}</div>
                    <div class="text-[10px] text-red-400 font-bold uppercase tracking-[0.2em]">Sản phẩm đang Flash Sale</div>
                </div>

                <!-- Danh mục Bán chạy -->
                <div class="card-beige p-8 bg-sepia-500 text-white border border-sepia-600 shadow-lg shadow-sepia-500/20 h-full flex flex-col justify-between">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-sepia-400 rounded-2xl text-white shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold text-sepia-200 uppercase tracking-widest">Top 1</span>
                    </div>
                    <div>
                        <div class="text-3xl font-bold tracking-tighter mb-2 text-white">{{ $bestSellingCategory ? $bestSellingCategory->name : 'N/A' }}</div>
                        <div class="text-[10px] text-sepia-200 font-bold uppercase tracking-[0.2em]">Danh mục bán chạy nhất</div>
                    </div>
                    @if($bestSellingCategory)
                    <div class="mt-6 pt-5 border-t border-sepia-600 flex justify-between items-center">
                        <span class="text-[9px] text-sepia-200 font-bold uppercase tracking-wide">Tổng đã bán</span>
                        <span class="text-base font-bold text-white">{{ number_format($bestSellingCategory->products_sum_sold_count) }}sp</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Khu vực Thống kê Tồn kho và Xuất báo cáo -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Data Table -->
                <div class="lg:col-span-2 card-beige bg-white border border-beige-200 overflow-hidden">
                    <div class="p-10 border-b border-beige-100 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-beige-50/30 gap-6">
                        <div>
                            <h3 class="text-lg font-bold text-earth-900 tracking-tight uppercase tracking-widest">Thống kê Hàng tồn kho theo Danh mục</h3>
                            <p class="text-[10px] text-earth-300 font-bold uppercase tracking-widest mt-2">Dữ liệu được cập nhật theo thời gian thực</p>
                        </div>
                        <a href="{{ route('admin.dashboard.export') }}" target="_blank" class="px-8 py-4 bg-earth-900 text-white rounded-[2rem] text-[10px] font-bold uppercase tracking-[0.2em] shadow-xl shadow-earth-900/20 hover:-translate-y-1 hover:bg-sepia-600 transition duration-500 flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Xuất Excel (.xls)
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-beige-50/50">
                                    <th class="py-6 px-10 text-[10px] font-bold text-earth-400 uppercase tracking-[0.2em]">Tên Danh Mục</th>
                                    <th class="py-6 px-10 text-[10px] font-bold text-earth-400 uppercase tracking-[0.2em] text-right">Tồn Kho</th>
                                    <th class="py-6 px-10 text-[10px] font-bold text-earth-400 uppercase tracking-[0.2em] text-right">Đã Bán</th>
                                    <th class="py-6 px-10 text-[10px] font-bold text-earth-400 uppercase tracking-[0.2em] text-right">Tổng Nhập</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-beige-100">
                                @forelse($categoryStats as $cat)
                                    <tr class="hover:bg-beige-50/30 transition">
                                        <td class="py-6 px-10 font-bold text-earth-800">{{ $cat->name }}</td>
                                        <td class="py-6 px-10 text-right"><span class="bg-earth-100 text-earth-600 px-3 py-1 rounded text-xs font-bold">{{ number_format($cat->products_sum_stock) }}</span></td>
                                        <td class="py-6 px-10 text-right"><span class="bg-sepia-100 text-sepia-600 px-3 py-1 rounded text-xs font-bold">{{ number_format($cat->products_sum_sold_count) }}</span></td>
                                        <td class="py-6 px-10 text-right font-bold text-earth-900">{{ number_format($cat->products_sum_stock + $cat->products_sum_sold_count) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-10 text-center text-earth-200">Chưa có dữ liệu danh mục</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Chart Box -->
                <div class="card-beige bg-white border border-beige-200 p-8 flex flex-col justify-center items-center">
                    <h3 class="text-sm font-bold text-earth-900 tracking-tight uppercase tracking-widest w-full text-center border-b border-beige-100 pb-6 mb-6">Tỷ trọng Tồn kho</h3>
                    <div class="w-full relative py-4 flex-1 flex items-center justify-center min-h-[300px]">
                        <canvas id="inventoryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Khu vực Thống kê Doanh Thu -->
            <div class="card-beige bg-white border border-beige-200 p-8 flex flex-col w-full">
                <div class="border-b border-beige-100 pb-6 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                    <div>
                        <h3 class="text-lg font-bold text-earth-900 tracking-tight uppercase tracking-widest">Biểu đồ Doanh thu năm nay</h3>
                        <p class="text-[10px] text-earth-300 font-bold uppercase tracking-widest mt-2">Doanh thu từ các đơn hàng đã hoàn thành</p>
                    </div>
                    <a href="{{ route('admin.dashboard.export_revenue') }}" target="_blank" class="px-8 py-4 bg-sepia-600 text-white rounded-[2rem] text-[10px] font-bold uppercase tracking-[0.2em] shadow-xl shadow-sepia-900/20 hover:-translate-y-1 hover:bg-earth-900 transition duration-500 flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Xuất Excel (.xls)
                    </a>
                </div>
                <div class="w-full relative py-4 h-[350px]">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Đơn hàng gần đây -->
            <div class="card-beige bg-white border border-beige-200 overflow-hidden">
                <div class="p-10 border-b border-beige-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-earth-900 tracking-tight uppercase tracking-widest">Đơn hàng mới nhất</h3>
                        <p class="text-[10px] text-earth-300 font-bold uppercase tracking-widest mt-2">Cập nhật theo thời gian thực</p>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="px-6 py-2 bg-beige-100 text-earth-500 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-sepia-500 hover:text-white transition duration-300">Tất cả đơn hàng</a>
                </div>
                
                <div class="overflow-x-auto">
                    @if($recentOrders->count() > 0)
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-beige-50/50">
                                    <th class="py-6 px-10 text-[10px] font-bold text-earth-400 uppercase tracking-[0.2em]">Mã đơn</th>
                                    <th class="py-6 px-10 text-[10px] font-bold text-earth-400 uppercase tracking-[0.2em]">Khách hàng</th>
                                    <th class="py-6 px-10 text-[10px] font-bold text-earth-400 uppercase tracking-[0.2em]">Thời gian</th>
                                    <th class="py-6 px-10 text-[10px] font-bold text-earth-400 uppercase tracking-[0.2em]">Giá trị</th>
                                    <th class="py-6 px-10 text-[10px] font-bold text-earth-400 uppercase tracking-[0.2em]">Trạng thái</th>
                                    <th class="py-6 px-10 text-[10px] font-bold text-earth-400 uppercase tracking-[0.2em] text-right">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-beige-100">
                                @foreach($recentOrders as $order)
                                    <tr class="hover:bg-beige-50/30 transition">
                                        <td class="py-8 px-10 font-bold text-sepia-600">#RD-{{ $order->id }}</td>
                                        <td class="py-8 px-10">
                                            <div class="font-bold text-earth-800">{{ $order->customer_name ?? ($order->user->name ?? 'Khách vãng lai') }}</div>
                                            <div class="text-[10px] text-earth-300 mt-1 uppercase font-medium">{{ $order->customer_phone ?? 'N/A' }}</div>
                                        </td>
                                        <td class="py-8 px-10 text-sm text-earth-400 font-medium">{{ $order->created_at->diffForHumans() }}</td>
                                        <td class="py-8 px-10 font-bold text-earth-900">{{ number_format($order->total_price) }}đ</td>
                                        <td class="py-8 px-10">
                                            @php
                                                $statusClasses = [
                                                    'Pending' => 'bg-beige-200 text-earth-500',
                                                    'Shipping' => 'bg-blue-50 text-blue-600',
                                                    'Completed' => 'bg-sepia-500 text-white',
                                                    'Cancelled' => 'bg-red-50 text-red-400'
                                                ];
                                                $statusText = [
                                                    'Pending' => 'Chờ xử lý',
                                                    'Shipping' => 'Đang giao',
                                                    'Completed' => 'Hoàn thành',
                                                    'Cancelled' => 'Đã hủy'
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest {{ $statusClasses[$order->status] ?? 'bg-beige-100' }}">
                                                {{ $statusText[$order->status] ?? $order->status }}
                                            </span>
                                        </td>
                                        <td class="py-8 px-10 text-right">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-sepia-600 hover:text-sepia-800 font-bold text-xs uppercase tracking-widest border-b border-sepia-200 pb-1">Chi tiết</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-20 text-center text-earth-200 font-medium italic">Chưa có dữ liệu đơn hàng gần đây.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('inventoryChart').getContext('2d');
            var chartLabels = {!! $chartLabels !!};
            var chartStockData = {!! $chartStockData !!};
            
            var inventoryChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Sản phẩm Tồn kho',
                        data: chartStockData,
                        backgroundColor: [
                            '#7c5945', // earth-500
                            '#cbb692', // beige-500
                            '#704214', // sepia-500
                            '#a67c52', // sepia-400
                            '#d5b593', // sepia-300
                            '#3d2517', // earth-800
                            '#987c6c'  // earth-400
                        ],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    family: "'Montserrat', sans-serif",
                                    size: 10,
                                    weight: 'bold'
                                },
                                usePointStyle: true,
                            }
                        }
                    }
                }
            });

            // Biểu đồ Doanh thu
            var revCtx = document.getElementById('revenueChart').getContext('2d');
            var revenueChart = new Chart(revCtx, {
                type: 'bar',
                data: {
                    labels: {!! $chartRevenueLabels !!},
                    datasets: [{
                        label: 'Doanh thu (VNĐ)',
                        data: {!! $chartRevenueData !!},
                        backgroundColor: '#a67c52', // sepia-400
                        borderRadius: 6,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString() + ' đ';
                                },
                                font: { size: 10, family: "'Montserrat', sans-serif", weight: 'bold' }
                            },
                            grid: { color: '#f3ece2', borderDash: [5, 5] }
                        },
                        x: {
                            ticks: { font: { size: 10, family: "'Montserrat', sans-serif", weight: 'bold' } },
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Doanh thu: ' + context.raw.toLocaleString() + ' VNĐ';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
