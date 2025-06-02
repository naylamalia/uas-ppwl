@extends('layouts.customer') 
@section('title', 'Daftar Produk')

@push('styles')
<style>
    .product-title {
        color: #d63384;
    }
    .card-product {
        border-radius: 1rem;
        transition: all 0.3s ease;
        background-color: #fff;
    }
    .card-product:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    .btn-detail {
        border-radius: 50px;
        font-weight: 500;
        background: #f8d7e6;
        color: #d63384;
        border: none;
    }
    .btn-detail:hover {
        background: #d63384;
        color: #fff;
    }
    .badge-soft {
        background-color: #fce3ec;
        color: #d63384;
        font-weight: 500;
        border-radius: 999px;
    }
    .badge-stock {
        font-weight: 500;
        border-radius: 999px;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold product-title">🌸 Daftar Produk</h2>

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
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
    </form>

    {{-- Product List --}}
    <div class="row">
        @forelse ($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card card-product h-100 shadow-sm border-0">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height:200px;object-fit:cover;border-top-left-radius:1rem;border-top-right-radius:1rem;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;border-top-left-radius:1rem;border-top-right-radius:1rem;">
                            <span class="text-muted">Tidak ada gambar</span>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="card-title text-truncate fw-semibold mb-1">{{ $product->name }}</h5>
                        <p class="text-danger fw-bold mb-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        <div class="mb-2 d-flex flex-wrap gap-1">
                            <span class="badge badge-soft">{{ ucfirst($product->category) }}</span>
                            <span class="badge badge-stock {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Habis' }}
                            </span>
                        </div>
                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('customer.products.show', $product->id) }}" class="btn btn-detail w-100">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                            @if($product->stock > 0)
                                <form action="{{ route('customer.cart.add', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100" style="border-radius:50px;">
                                        <i class="bi bi-cart-plus"></i> Keranjang
                                    </button>
                                </form>
                            @endif
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