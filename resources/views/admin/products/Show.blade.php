{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\admin\products\Show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
<div class="container mt-4">
    <h2>Detail Produk</h2>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $product->name }}</h4>
            <p><strong>Kode:</strong> {{ $product->code }}</p>
            <p><strong>Kategori:</strong> {{ $product->category }}</p>
            <p><strong>Harga:</strong> Rp{{ number_format($product->price, 0, ',', '.') }}</p>
            <p><strong>Stok:</strong> {{ $product->stock }}</p>
            <p><strong>Deskripsi:</strong> {{ $product->description ?? '-' }}</p>
            <p>
                <strong>Gambar:</strong><br>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="200">
                @else
                    <span class="text-muted">Tidak ada gambar</span>
                @endif
            </p>
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection