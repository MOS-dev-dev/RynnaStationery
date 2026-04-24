<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; vertical-align: middle; }
        th { background-color: #f2f2f2; font-weight: bold; color: #333; }
        .header-title { font-size: 20px; font-weight: bold; text-align: center; border: none; height: 50px; }
        .money { text-align: right; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="4" class="header-title">BÁO CÁO TỒN KHO THEO DANH MỤC THÁNG {{ \Carbon\Carbon::now()->format('m/Y') }}</td>
        </tr>
        <tr>
            <td colspan="4" style="border:none; text-align:center;">Ngày xuất báo cáo: {{ \Carbon\Carbon::now()->format('H:i d/m/Y') }}</td>
        </tr>
        <tr>
            <td colspan="4" style="border:none;"></td>
        </tr>
        <tr style="background-color: #4CAF50; color: white;">
            <th>Tên Danh Mục</th>
            <th>Số lượng Tồn kho</th>
            <th>Số lượng Đã bán</th>
            <th>Tổng Lượng Nhập (Tồn + Bán)</th>
        </tr>
        @if($categoryStats->count() > 0)
            @foreach($categoryStats as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->products_sum_stock ?? 0 }}</td>
                    <td>{{ $category->products_sum_sold_count ?? 0 }}</td>
                    <td>{{ ($category->products_sum_stock ?? 0) + ($category->products_sum_sold_count ?? 0) }}</td>
                </tr>
            @endforeach
            <tr style="font-weight: bold; background-color: #f9f9f9;">
                <td>TỔNG CỘNG</td>
                <td>{{ $categoryStats->sum('products_sum_stock') }}</td>
                <td>{{ $categoryStats->sum('products_sum_sold_count') }}</td>
                <td>{{ $categoryStats->sum('products_sum_stock') + $categoryStats->sum('products_sum_sold_count') }}</td>
            </tr>
        @else
            <tr>
                <td colspan="4" style="padding:20px;">Không có dữ liệu tồn kho trong khoảng thời gian này.</td>
            </tr>
        @endif
    </table>
</body>
</html>
