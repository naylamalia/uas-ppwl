{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\admin\products\Show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold" style="color:firebrick;">Detail Produk</h2>
    <div class="card shadow-sm" style="border-color:firebrick; background:#fff5f5;">
        <div class="card-body">
            <h4 class="card-title fw-bold" style="color:firebrick;">{{ $product->name }}</h4>
            <p><strong style="color:firebrick;">Kode:</strong> {{ $product->code }}</p>
            <p><strong style="color:firebrick;">Kategori:</strong> {{ $product->category }}</p>
            <p><strong style="color:firebrick;">Harga:</strong> <span style="color:firebrick;">Rp{{ number_format($product->price, 0, ',', '.') }}</span></p>
            <p>
                <strong style="color:firebrick;">Stok:</strong>
                @if($product->stock > 0)
                    <span class="badge" style="background:forestgreen; color:white;">{{ $product->stock }}</span>
                @else
                    <span class="badge" style="background:firebrick; color:white;">Habis</span>
                @endif
            </p>
            <p><strong style="color:firebrick;">Deskripsi:</strong> {{ $product->description ?? '-' }}</p>
            <p>
                <strong style="color:firebrick;">Gambar:</strong><br>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="200" style="border:2px solid firebrick; border-radius:8px;">
                @else
                    <span class="text-muted">Tidak ada gambar</span>
                @endif
            </p>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn" style="background:firebrick; color:white;">Edit</a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light">Kembali</a>
            </div>
        </div>
    </div>
</div>
{{-- Footer --}}
        <x-app.footer />
@endsection