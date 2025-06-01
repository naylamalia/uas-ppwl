@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold" style="color:firebrick; display:flex; align-items:center; gap:8px;">
        <i class="bi bi-receipt fs-3"></i> Daftar Order
    </h2>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden" style="border-color:firebrick; background:#fff5f5;">
        <div class="card-header" style="background:firebrick; color:white; border-color:firebrick;">
            <div class="fw-semibold fs-5 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-list-check me-2"></i> Order Terbaru
                    <span class="badge border bg-light text-white ms-3" style="font-size:1rem;">
                        Total: {{ $orders->count() }}
                    </span>
                </div>
                <a href="{{ route('admin.orders.export.pdf') }}" 
                   class="btn btn-sm" style="background:forestgreen; color:white;"
                   data-bs-toggle="tooltip" data-bs-placement="left" title="Unduh laporan PDF semua order">
                    <i class="bi bi-file-earmark-pdf"></i> Download PDF
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                    <thead style="background:firebrick; color:white; border-color:firebrick; opacity:0.85;">
                        <tr>
                            <th style="width:5%; color:white;">No</th>
                            <th style="width:20%; color:white;">Pelanggan</th>
                            <th style="width:30%; color:white;">Produk</th>
                            <th style="width:8%; color:white;" class="text-center">Jumlah</th>
                            <th style="width:12%; color:white;" class="text-center">Status</th>
                            <th style="width:15%; color:white;" class="text-center">Tanggal</th>
                            <th style="width:10%; color:white;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr class="align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-truncate" style="max-width: 150px;" title="{{ $order->user->name ?? '-' }}">
                                {{ $order->user->name ?? '-' }}
                            </td>
                            <td style="max-width: 350px;">
                                @if(isset($order->product))
                                    <span class="text-truncate d-block" title="{{ $order->product->name }}">{{ $order->product->name }}</span>
                                @elseif(isset($order->orderItems) && count($order->orderItems))
                                    @foreach($order->orderItems as $item)
                                        <div class="small text-muted" title="{{ $item->product->name ?? '-' }}">
                                            <i class="bi bi-box-seam me-1"></i> {{ $item->product->name ?? '-' }} 
                                            <span class="badge bg-secondary rounded-pill">x{{ $item->quantity }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center fw-semibold">
                                @if(isset($order->quantity))
                                    {{ $order->quantity }}
                                @elseif(isset($order->orderItems) && count($order->orderItems))
                                    {{ $order->orderItems->sum('quantity') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @php
                                    $status = $order->status_order;
                                    $badgeClass = match($status) {
                                        'belum_selesai' => 'bg-warning text-dark',
                                        'selesai' => 'bg-success',
                                        'batal', 'dibatalkan' => 'bg-danger',
                                        default => 'bg-secondary',
                                    };
                                    $statusIcons = [
                                        'belum_selesai' => 'bi-hourglass-split',
                                        'selesai' => 'bi-check-circle',
                                        'batal' => 'bi-x-circle',
                                        'dibatalkan' => 'bi-x-circle',
                                    ];
                                    $icon = $statusIcons[$status] ?? 'bi-info-circle';
                                @endphp
                                <span
                                    class="badge shadow-sm d-flex align-items-center gap-1 px-3 py-2"
                                    style="
                                        background: {{ $status == 'belum_selesai' ? 'rgba(245,158,66,0.12)' : ($status == 'selesai' ? 'rgba(34,197,94,0.12)' : ($status == 'batal' || $status == 'dibatalkan' ? 'rgba(220,53,69,0.12)' : 'rgba(108,117,125,0.12)')) }};
                                        border: 2px solid
                                            {{ $status == 'belum_selesai' ? '#f59e42' : ($status == 'selesai' ? '#22c55e' : ($status == 'batal' || $status == 'dibatalkan' ? '#dc3545' : '#6c757d')) }};
                                        color:
                                            {{ $status == 'belum_selesai' ? '#f59e42' : ($status == 'selesai' ? '#22c55e' : ($status == 'batal' || $status == 'dibatalkan' ? '#dc3545' : '#6c757d')) }};
                                        font-weight: 600;
                                        font-size: 1rem;
                                    ">
                                    <i class="bi {{ $icon }}"></i>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </span>
                            </td>
                            <td class="text-center">
                                {{-- Format tanggal dengan Carbon --}}
                                {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="btn btn-sm" style="background:firebrick; color:white;"
                                   data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat detail order">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5 fs-5">
                                <i class="bi bi-info-circle me-2"></i> Tidak ada data order.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .card {
        border-radius: 0.5rem;
        transition: box-shadow 0.2s;
    }
    .card:hover {
        box-shadow: 0 6px 24px rgba(220, 38, 38, 0.15); /* firebrick shadow */
    }
    .btn {
        border-radius: 0.375rem;
        transition: box-shadow 0.2s;
    }
    .btn:hover {
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4); /* firebrick shadow */
    }
</style>
@endpush

{{-- Tooltip activation --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection