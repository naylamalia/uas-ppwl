{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\Customer\Product\index.blade.php --}}
@extends('layouts.customer') 
@section('title', 'Daftar Produk')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">🛒 Daftar Produk</h2>

    <form method="GET" class="mb-4 row g-2">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control shadow-sm" placeholder="Cari produk...">
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select shadow-sm">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filter</button>
        </div>
    </form>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height:180px;object-fit:cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                            <span class="text-muted">Tidak ada gambar</span>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-semibold">{{ $product->name }}</h5>
                        <div class="mb-2 text-primary fw-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="mb-2">
                            <span class="badge bg-info text-dark">{{ ucfirst($product->category) }}</span>
                            <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Habis' }}
                            </span>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('customer.products.show', $product->id) }}" class="btn btn-sm btn-outline-primary w-100">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                <i class="bi bi-box-seam"></i> Tidak ada produk ditemukan.
            </div>
        @endforelse
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection