@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Daftar Produk</h2>
        <div>
            <a href="{{ route('admin.products.export.pdf') }}" class="btn btn-success shadow-sm me-2" title="Export PDF">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm">
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
            <button type="submit" class="btn btn-secondary w-100 shadow-sm">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
    </form>

    <div class="table-responsive shadow rounded">
        <table class="table table-hover align-middle text-center">
            <thead class="table-primary text-primary fw-semibold">
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="align-middle">
                    <td class="text-uppercase">{{ $product->code }}</td>
                    <td class="fw-semibold">{{ $product->name }}</td>
                    <td>{{ $product->category }}</td>
                    <td class="text-success fw-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        @if($product->stock > 0)
                            <span class="badge bg-success">{{ $product->stock }}</span>
                        @else
                            <span class="badge bg-danger">Habis</span>
                        @endif
                    </td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 70px; max-height: 70px;">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-info shadow-sm" title="Lihat">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning shadow-sm" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger shadow-sm" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted fst-italic py-4">Tidak ada produk ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Custom shadow and hover effect for table rows */
    table.table-hover tbody tr:hover {
        background-color: #e9f5ff;
        transition: background-color 0.3s ease;
    }

    /* Rounded buttons with subtle shadow */
    .btn {
        border-radius: 0.375rem;
        transition: box-shadow 0.2s ease;
    }

    .btn:hover {
        box-shadow: 0 4px 12px rgb(0 123 255 / 0.4);
    }
</style>
@endpush
