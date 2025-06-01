@extends('layouts.customer') 
@section('title', 'Daftar Produk')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .product-title {
        color: firebrick;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .card-product {
        border-radius: 0.5rem;
        transition: box-shadow 0.2s;
        background-color: #fff5f5;
        border: 1.5px solid firebrick;
    }
    .card-product:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 24px rgba(178,34,34,0.15); /* firebrick shadow */
    }
    .btn-detail {
        border-radius: 0.375rem;
        font-weight: 500;
        background: firebrick;
        color: #fff;
        border: none;
        transition: box-shadow 0.2s;
    }
    .btn-detail:hover, .btn-detail:focus {
        background: #b22222;
        color: #fff;
        box-shadow: 0 4px 12px rgba(178,34,34,0.4);
    }
    .badge-soft {
        background-color: #fff;
        color: firebrick;
        font-weight: 500;
        border-radius: 999px;
        border: 1px solid firebrick;
    }
    .badge-stock {
        font-weight: 500;
        border-radius: 999px;
        color: #fff;
        background-color: firebrick;
        border: 1px solid firebrick;
    }
    .badge-stock.bg-success {
        background-color: forestgreen !important;
        border-color: forestgreen !important;
        color: #fff !important;
    }
    .badge-stock.bg-danger {
        background-color: firebrick !important;
        border-color: firebrick !important;
        color: #fff !important;
    }
    .card-img-top {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold product-title"><i class="bi bi-box-seam"></i> Daftar Produk</h2>

    {{-- Filter Form --}}
    <form method="GET" class="mb-4 row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label text-muted">Cari Produk</label>
            <input type="text" name="search" value="{{ request('search') }}" class="form-control shadow-sm" placeholder="Contoh: Samsung, Iphone...">
        </div>
        <div class="col-md-4">
            <label class="form-label text-muted">Kategori</label>
            <select name="category" class="form-select shadow-sm">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn" style="background:firebrick; color:white; width:100%;">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
    </form>

    {{-- Product List --}}
    <div class="row">
        @forelse ($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card card-product h-100 shadow-sm">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height:200px;object-fit:cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                            <span class="text-muted">Tidak ada gambar</span>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="card-title text-truncate fw-semibold mb-1" style="color:firebrick;">{{ $product->name }}</h5>
                        <p class="fw-bold mb-2" style="color:firebrick;">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        <div class="mb-2 d-flex flex-wrap gap-1">
                            <span class="badge badge-soft">{{ ucfirst($product->category) }}</span>
                            <span class="badge badge-stock {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Habis' }}
                            </span>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('customer.products.show', $product->id) }}" class="btn btn-detail w-100">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                <i class="bi bi-box-seam fs-3 mb-2 d-block"></i> Tidak ada produk ditemukan.
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection