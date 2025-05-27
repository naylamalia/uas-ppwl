<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
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
            background-color: #007bff;
            color: white;
        }
        .text-success {
            color: green;
            font-weight: bold;
        }
        .badge-success {
            background-color: green;
            color: white;
            padding: 3px 6px;
            border-radius: 4px;
        }
        .badge-danger {
            background-color: red;
            color: white;
            padding: 3px 6px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h2>Laporan Produk</h2>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ strtoupper($product->code) }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category }}</td>
                <td class="text-success">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                <td>
                    @if($product->stock > 0)
                        <span class="badge-success">{{ $product->stock }}</span>
                    @else
                        <span class="badge-danger">Habis</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
