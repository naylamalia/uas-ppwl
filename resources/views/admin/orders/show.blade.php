@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <h2 class="mb-5 fw-bold" style="color:firebrick;">
        <i class="bi bi-receipt"></i> Detail Order
    </h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-5 mb-5" style="border-color:firebrick; background:#fff5f5;">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="mb-3 fs-5"><strong style="color:firebrick;">No. Pesanan:</strong> <span class="text-secondary">#{{ $order->id }}</span></div>
                    <div class="mb-3 fs-5"><strong style="color:firebrick;">Pelanggan:</strong> <span class="text-secondary">{{ $order->user->name ?? '-' }}</span></div>
                    <div class="mb-3 fs-5">
                        <strong style="color:firebrick;">Tanggal Pesan:</strong>
                        <span class="text-secondary">
                            {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-column justify-content-between">
                    <div class="mb-3 fs-5">
                        <strong style="color:firebrick;">Status:</strong>
                        @php
                            $status = $order->status_order;
                            $statusColors = [
                                'belum_selesai' => ['bg' => 'rgba(245,158,66,0.12)', 'border' => '#f59e42', 'color' => '#f59e42', 'icon' => 'bi-hourglass-split'],
                                'selesai' => ['bg' => 'rgba(34,197,94,0.12)', 'border' => '#22c55e', 'color' => '#22c55e', 'icon' => 'bi-check-circle'],
                                'default' => ['bg' => 'rgba(108,117,125,0.12)', 'border' => '#6c757d', 'color' => '#6c757d', 'icon' => 'bi-info-circle'],
                            ];
                            $sc = $statusColors[$status] ?? $statusColors['default'];
                        @endphp
                        <span class="badge shadow-sm d-flex align-items-center gap-1 px-3 py-2"
                            style="
                                background: {{ $sc['bg'] }};
                                border: 2px solid {{ $sc['border'] }};
                                color: {{ $sc['color'] }};
                                font-weight: 600;
                                font-size: 1rem;
                            ">
                            <i class="bi {{ $sc['icon'] }}"></i>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </span>
                    </div>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-flex align-items-center gap-3">
                        @csrf
                        @method('PATCH')
                        <label for="status_order" class="form-label mb-0 fw-semibold" style="color:firebrick;">Ubah Status:</label>
                        <select name="status_order" id="status_order" class="form-select form-select-sm w-auto" required>
                            <option value="belum_selesai" {{ $order->status_order == 'belum_selesai' ? 'selected' : '' }}>Belum Selesai</option>
                            <option value="selesai" {{ $order->status_order == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <button type="submit" class="btn btn-sm" style="background:firebrick; color:white;">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-light">Kembali</a>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-5">
        <div class="card-header" style="background:firebrick; color:white; border-top-left-radius:1.5rem; border-top-right-radius:1.5rem;">
            <span class="fw-bold fs-5 d-flex align-items-center gap-2">
                <i class="bi bi-box-seam fs-4"></i> Produk Dipesan
            </span>
        </div>
        <div class="card-body p-0" style="background:#fff5f5; opacity:0.85;">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:firebrick; color:white;">
                    <tr>
                        <th>Nama Produk</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end">Harga Satuan</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-semibold">{{ $order->product->name ?? '-' }}</td>
                        <td class="text-center">{{ $order->quantity }}</td>
                        <td class="text-end">Rp{{ number_format($order->price / max($order->quantity, 1), 0, ',', '.') }}</td>
                        <td class="text-end fw-bold" style="color:firebrick;">Rp{{ number_format($order->price, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="table-light fs-5 fw-bold">
                        <th colspan="3" class="text-end">Total</th>
                        <th class="text-end" style="color:firebrick;">Rp{{ number_format($order->price ?? $order->total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection