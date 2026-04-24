<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table>
        <thead>
            <tr>
                <th colspan="2" style="font-weight: bold; font-size: 16px; text-align: center;">
                    BÁO CÁO DOANH THU NĂM {{ date('Y') }}
                </th>
            </tr>
            <tr>
                <th style="font-weight: bold; background-color: #f3ece2;">Tháng</th>
                <th style="font-weight: bold; background-color: #f3ece2;">Doanh thu (VNĐ)</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($monthlyRevenueData as $month => $revenue)
                @php $total += $revenue; @endphp
                <tr>
                    <td>Tháng {{ $month }}</td>
                    <td>{{ $revenue }}</td>
                </tr>
            @endforeach
            <tr>
                <td style="font-weight: bold; background-color: #f3ece2;">TỔNG CỘNG</td>
                <td style="font-weight: bold; background-color: #f3ece2;">{{ $total }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
