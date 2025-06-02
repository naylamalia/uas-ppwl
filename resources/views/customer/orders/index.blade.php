@extends('components.app.navbar')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-firebrick"><i class="bi bi-receipt"></i> Riwayat Pesanan Saya</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($orders->count() > 0)
        <div class="row g-4">
            @foreach($orders as $order)
            <div class="col-12">
                <div class="card shadow border-0 h-100 order-card">
                    <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width:60px; height:60px;">
                                <i class="bi bi-box-seam fs-2" style="color:firebrick;"></i>
                            </div>
                            <div>
                                @foreach($order->orderItems as $item)
                                    <div class="fw-semibold fs-5 mb-1">{{ $item->product->name ?? '-' }}</div>
                                    <div class="small text-muted mb-1">x{{ $item->quantity ?? 1 }}</div>
                                @endforeach
                                <div class="small text-muted">
                                    <i class="bi bi-calendar"></i>
                                    {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="text-end flex-shrink-0 ms-3" style="min-width:150px;">
                            <div class="fw-bold text-firebrick fs-5 mb-2">Rp{{ number_format($order->price ?? 0, 0, ',', '.') }}</div>
                            <span class="badge 
                                @if($order->status_order == 'belum_selesai') badge-warning
                                @elseif($order->status_order == 'selesai') badge-success
                                @elseif($order->status_order == 'batal' || $order->status_order == 'dibatalkan') badge-danger
                                @else badge-danger
                                @endif
                                px-3 py-2 text-capitalize">
                                {{ str_replace('_', ' ', $order->status_order) }}
                            </span>
                        </div>
                        <div class="ms-3">
                            <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-outline-firebrick btn-sm rounded-pill" title="Detail">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ method_exists($orders, 'links') ? $orders->links() : '' }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-receipt fs-1 text-muted"></i>
            <p class="mt-3 text-muted">Belum ada pesanan.</p>
            <a href="{{ route('customer.products.index') }}" class="btn btn-firebrick">
                <i class="bi bi-arrow-left"></i> Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.text-firebrick {
    color: firebrick !important;
}
.btn-firebrick, .btn-outline-firebrick {
    border-color: firebrick !important;
    color: #fff !important;
    background: firebrick !important;
}
.btn-outline-firebrick {
    background: #fff !important;
    color: firebrick !important;
}
.btn-firebrick:hover, .btn-outline-firebrick:hover, .btn-firebrick:focus, .btn-outline-firebrick:focus {
    background: #b22222 !important;
    color: #fff !important;
    border-color: #b22222 !important;
}
.order-card {
    transition: box-shadow .2s;
}
.order-card:hover {
    box-shadow: 0 0.5rem 1.5rem rgba(178,34,34,.12);
    border-color: #b2222222;
}
.badge {
    font-size: 1em;
    border-radius: 0.5rem;
    letter-spacing: .5px;
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
@endpush