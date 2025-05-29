<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Order</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background: #eee; }
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
                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                <td>{{ ucfirst($order->status_order) }}</td>
                <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>