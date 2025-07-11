{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\Customer\orders\show.blade.php --}}
@extends('components.app.navbar')
@section('title', 'Detail Pesanan')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-firebrick rounded-pill shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
        </a>
    </div>
    <h2 class="mb-4 fw-bold text-primary"><i class="bi bi-receipt"></i> Detail Pesanan</h2>

    <div class="card shadow-sm rounded-4 mb-4 border-0 bg-white">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6 mb-2 mb-md-0">
                    <div class="mb-2"><strong>No. Pesanan:</strong> #{{ $order->id }}</div>
                    <div class="mb-2"><strong>Tanggal Pesan:</strong>
                        {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}
                    </div>
                    <div class="mb-2"><strong>Status:</strong>
                        <span class="badge
                            @if($order->status_order == 'belum_selesai') bg-warning text-dark
                            @elseif($order->status_order == 'selesai') bg-success
                            @elseif($order->status_order == 'batal') bg-danger
                            @else bg-secondary
                            @endif
                        ">
                            {{ ucfirst($order->status_order) }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="mb-2"><strong>Alamat Pengiriman:</strong></div>
                    <div class="mb-2">{{ $order->alamat }}</div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6 mb-2 mb-md-0">
                    <strong>Catatan/Rincian Pemesanan:</strong>
                    <div>{{ $order->rincian_pemesanan ? $order->rincian_pemesanan : '-' }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Pembayaran:</strong>
                    <div>
                        @if($order->pilihan_cod)
                            <span class="badge bg-info text-dark">Bayar di Tempat (COD)</span>
                        @else
                            <span class="badge bg-secondary">Transfer</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm rounded-4 border-0 mb-4 bg-white">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="bi bi-box-seam"></i> Produk Dipesan
        </div>
        <div class="card-body p-0">
            <table class="table align-middle mb-0">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th>Nama Produk</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end">Harga Satuan</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->orderItems as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-light rounded shadow-sm" style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                                        <i class="bi bi-box-seam text-primary"></i>
                                    </div>
                                    <span>{{ $item->product->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-end">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada produk pada pesanan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th class="text-end text-primary">Rp{{ number_format($order->price ?? $order->total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #f8fafc 0%, #e0e7ef 100%);
    }
    .card {
        border-radius: 1.25rem;
    }
    .table th, .table td {
        vertical-align: middle !important;
    }
    .badge {
        font-size: 1em;
        border-radius: 0.5rem;
        letter-spacing: .5px;
    }
    .bg-primary {
        background: firebrick !important;
    }
    .text-primary {
        color: firebrick !important;
    }
    .btn-outline-firebrick {
        border-color: firebrick !important;
        color: firebrick !important;
    }
    .btn-outline-firebrick:hover, .btn-outline-firebrick:focus {
        background: firebrick !important;
        color: #fff !important;
        border-color: firebrick !important;
    }
</style>
@endpush