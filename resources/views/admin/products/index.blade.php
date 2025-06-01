@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color:firebrick; display:flex; align-items:center; gap:8px;">
             <i class="bi bi-box-seam"></i>Daftar Produk</h2>
        <div>
            <a href="{{ route('admin.products.export.pdf') }}" class="btn" style="background:forestgreen; color:white;" title="Export PDF">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn" style="background:firebrick; color:white;">
                <i class="bi bi-plus-lg"></i> Tambah Produk
            </a>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control shadow-sm" placeholder="Cari nama produk..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select shadow-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="price" class="form-select shadow-sm">
                <option value="">Filter Harga</option>
                <option value="1" {{ request('price') == '1' ? 'selected' : '' }}>Rp 1.000.000 - Rp 5.000.000</option>
                <option value="2" {{ request('price') == '2' ? 'selected' : '' }}>Rp 6.000.000 - Rp 10.000.000</option>
                <option value="3" {{ request('price') == '3' ? 'selected' : '' }}>Rp 11.000.000 - Rp 15.000.000</option>
                <option value="4" {{ request('price') == '4' ? 'selected' : '' }}>Lebih dari Rp 15.000.000</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-center">
            <button type="submit" class="btn" style="background:firebrick; color:white; width:100%;">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
    </form>

    {{-- Layout grid e-commerce --}}
    <div class="row">
        @forelse($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm" style="border-color:firebrick; background:#fff5f5;">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height:180px;object-fit:cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                        <span class="text-muted">Tidak ada gambar</span>
                    </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-semibold" style="color:firebrick;">{{ $product->name }}</h5>
                    <div class="mb-2" style="color:firebrick;">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="mb-2">
                        @php
                            $badgeColor = $product->stock > 0 ? 'forestgreen' : 'firebrick';
                        @endphp
                        <span class="badge" style="background-color: {{ $badgeColor }}; color: white;">
                            {{ $product->stock > 0 ? $product->stock : 'Habis' }}
                        </span>
                        <span class="ms-2 text-secondary">{{ $product->category }}</span>
                    </div>
                    <div class="mt-auto justify-content-center d-flex gap-2">
                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm" style="background:#ffb3b3; color:firebrick;" title="Lihat">
                            <i class="bi bi-eye" style="font-size:1.1em; vertical-align:middle;"></i>
                        </a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm" style="background:chocolate; color:white;" title="Edit">
                            <i class="bi bi-pencil" style="font-size:1.1em; vertical-align:middle;"></i>
                        </a>
                        <button type="button"
                            class="btn btn-sm btn-delete-product"
                            style="background:firebrick; color:white;"
                            data-product-id="{{ $product->id }}"
                            data-product-name="{{ $product->name }}"
                            title="Hapus">
                            <i class="bi bi-trash" style="font-size:1.1em; vertical-align:middle;"></i>
                        </button>
                        <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted fst-italic py-4">
            Tidak ada produk ditemukan.
        </div>
        @endforelse
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $products->withQueryString()->links() }}
    </div>
</div>

<!-- Custom Delete Modal for Produk -->
<div class="modal" tabindex="-1" id="deleteProductModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3);">
    <div style="background:#fff; max-width:350px; margin:10% auto; border-radius:8px; box-shadow:0 2px 8px #0002; padding:24px; text-align:center;">
        <div class="mb-3">
            <i class="bi bi-exclamation-triangle" style="font-size:2.5rem; color:firebrick;"></i>
        </div>
        <div class="mb-3">
            <div class="fw-bold mb-2" id="deleteProductModalText">Yakin ingin menghapus produk ini?</div>
        </div>
        <div class="d-flex justify-content-center gap-2">
            <button type="button" id="cancelDeleteProduct" class="btn btn-secondary btn-sm px-4">Batal</button>
            <button type="button" id="confirmDeleteProduct" class="btn btn-danger btn-sm px-4">Hapus</button>
        </div>
    </div>
</div>

<script>
    let selectedProductId = null;
    document.querySelectorAll('.btn-delete-product').forEach(function(btn) {
        btn.addEventListener('click', function() {
            selectedProductId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            document.getElementById('deleteProductModalText').innerText = `Yakin ingin menghapus produk "${productName}"?`;
            document.getElementById('deleteProductModal').style.display = 'block';
        });
    });

    document.getElementById('cancelDeleteProduct').onclick = function() {
        document.getElementById('deleteProductModal').style.display = 'none';
        selectedProductId = null;
    };

    document.getElementById('confirmDeleteProduct').onclick = function() {
        if(selectedProductId) {
            document.getElementById('delete-form-' + selectedProductId).submit();
        }
    };

    // Optional: close modal if click outside modal box
    document.getElementById('deleteProductModal').addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
</script>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .card-img-top {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
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