<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: firebrick;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #999;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: firebrick;
            color: white;
        }
        .badge-success {
            background-color: forestgreen;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
        }
        .badge-warning {
            background-color: #f59e42;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
        }
        .badge-danger {
            background-color: firebrick;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Laporan Order</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama User</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->user->name ?? '-' }}</td>
                <td>{{ $order->created_at ? $order->created_at->format('d-m-Y') : '-' }}</td>
                <td>
                    @php
                        $status = $order->status_order;
                        $badgeClass = match($status) {
                            'belum_selesai' => 'badge-warning',
                            'selesai' => 'badge-success',
                            'dibatalkan', 'batal' => 'badge-danger',
                            default => 'badge-danger',
                        };
                    @endphp
                    <span class="{{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                </td>
                <td>Rp{{ number_format($order->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>