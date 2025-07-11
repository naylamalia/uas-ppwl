@extends('layouts.admin')

@section('title', 'Daftar Stok Produk')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color:firebrick; display:flex; align-items:center; gap:8px;">
            <i class="bi bi-archive"></i>Daftar Stok Produk
        </h2>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive shadow rounded-4 overflow-hidden border">
        <table class="table table-hover align-middle mb-0">
            <thead style="background-color: firebrick;" class="text-white text-center">
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 15%;" class="text-center">Kode Produk</th>
                    <th class="text-center">Nama Produk</th>
                    <th class="text-center">Kategori</th>
                    <th style="width: 10%;">Stok</th>
                    <th style="width: 15%;">Harga</th>
                    <th style="width: 12%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="align-middle">
                    <td class="text-center text-secondary">{{ $loop->iteration + ($products->firstItem() - 1) }}</td>
                    <td class="text-uppercase text-center fw-semibold">{{ $product->code }}</td>
                    <td class="fw-semibold text-center">{{ $product->name }}</td>
                    <td class="text-muted text-center">{{ $product->category }}</td>
                    <td class="text-center">
                        @if($product->stock > 0)
                            <span class="badge rounded-pill px-3 py-2 fs-6" style="background:#ffb3b3; color:firebrick;">
                                {{ $product->stock }}
                            </span>
                        @else
                            <span class="badge text-white rounded-pill px-3 py-2 fs-6" style="background-color: #555;">
                                Habis
                            </span>
                        @endif
                    </td>
                    <td class="text-end fw-bold text-success text-center">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.stock.form', $product->id) }}" 
                           class="btn btn-outline-danger btn-sm shadow-sm px-3 p-2 m-2">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Stok
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted fst-italic py-5">
                        <i class="bi bi-box-seam fs-3"></i><br>
                        Tidak ada data stok produk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-center text-center">
        {{ $products->links() }}
    </div>
    {{-- Footer --}}
        <x-app.footer />
</div>
@endsection