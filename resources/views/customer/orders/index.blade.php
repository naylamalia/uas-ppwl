{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\Customer\orders\index.blade.php --}}
@extends('layouts.customer')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-pink"><i class="bi bi-receipt"></i> Riwayat Pesanan Saya</h2>

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
                                <i class="bi bi-box-seam fs-2" style="color:#ed5aba;"></i>
                            </div>
                            <div>
                                <div class="fw-semibold fs-5 mb-1">{{ $order->product->name ?? '-' }}</div>
                                <div class="small text-muted mb-1">x{{ $order->quantity ?? 1 }}</div>
                                <div class="small text-muted">
                                    <i class="bi bi-calendar"></i>
                                    {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="text-end flex-shrink-0 ms-3" style="min-width:150px;">
                            <div class="fw-bold text-pink fs-5 mb-2">Rp{{ number_format($order->price ?? 0, 0, ',', '.') }}</div>
                            <span class="badge 
                                @if($order->status_order == 'belum_selesai') bg-warning
                                @elseif($order->status_order == 'selesai') bg-success
                                @elseif($order->status_order == 'batal') bg-danger
                                @else bg-secondary
                                @endif
                                px-3 py-2 text-capitalize"
                                style="background:{{ $order->status_order == 'belum_selesai' ? '#fff0f6' : '' }};
                                       color:{{ $order->status_order == 'belum_selesai' ? '#ed5aba' : '' }};
                                ">
                                {{ str_replace('_', ' ', $order->status_order) }}
                            </span>
                        </div>
                        <div class="ms-3">
                            <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-outline-pink btn-sm rounded-pill" title="Detail">
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
            <a href="{{ route('customer.products.index') }}" class="btn btn-pink">
                <i class="bi bi-arrow-left"></i> Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.order-card {
    transition: box-shadow .2s;
}
.order-card:hover {
    box-shadow: 0 0.5rem 1.5rem rgba(237,90,186,.12);
    border-color: #ed5aba22;
}
.badge {
    font-size: 1em;
    border-radius: 0.5rem;
    letter-spacing: .5px;
}
.text-pink {
    color: #ed5aba !important;
}
.btn-pink, .btn-outline-pink {
    border-color: #ed5aba !important;
    color: #fff !important;
    background: #ed5aba !important;
}
.btn-outline-pink {
    background: #fff !important;
    color: #ed5aba !important;
}
.btn-pink:hover, .btn-outline-pink:hover, .btn-pink:focus, .btn-outline-pink:focus {
    background: #e35dd2 !important;
    color: #fff !important;
    border-color: #e35dd2 !important;
}
</style>
@endpush