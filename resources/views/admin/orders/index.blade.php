@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-primary d-flex align-items-center gap-2">
        <i class="bi bi-receipt fs-3"></i> Daftar Order
    </h2>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-gradient-primary text-white fw-semibold fs-5 d-flex align-items-center justify-content-between">
            <div><i class="bi bi-list-check me-2"></i> Order Terbaru</div>
            <div class="d-flex align-items-center gap-3">
                {{-- Tombol Download PDF --}}
                <a href="{{ route('admin.orders.export.pdf') }}" 
                   class="btn btn-sm btn-light text-primary shadow-sm d-flex align-items-center gap-2"
                   data-bs-toggle="tooltip" data-bs-placement="left" title="Unduh laporan PDF semua order">
                    <i class="bi bi-file-earmark-pdf"></i> Download PDF
                </a>
                {{-- Info jumlah order --}}
                <span class="text-white-50" style="font-size: 0.9rem;">Total: {{ $orders->count() }}</span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                    <thead class="table-light text-uppercase text-secondary">
                        <tr>
                            <th style="width:5%;">No</th>
                            <th style="width:20%;">Pelanggan</th>
                            <th style="width:30%;">Produk</th>
                            <th style="width:8%;" class="text-center">Jumlah</th>
                            <th style="width:12%;">Status</th>
                            <th style="width:15%;">Tanggal</th>
                            <th style="width:10%;">Aksi</th>
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
                                <span class="badge {{ $badgeClass }} shadow-sm d-flex align-items-center gap-1 px-3 py-2">
                                    <i class="bi {{ $icon }}"></i>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="btn btn-sm btn-outline-primary shadow-sm" 
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