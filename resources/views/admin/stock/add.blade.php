{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\admin\stock\add.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Stok Produk')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold" style="color:firebrick;">Tambah Stok Produk</h2>
    <form action="{{ route('admin.stock.add', $product->id) }}" method="POST" class="card p-4 shadow-sm" style="border-color:firebrick; background:#fff5f5;">
        @csrf

        {{-- Flash message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label" style="color:firebrick;">Kode Produk</label>
            <input type="text" class="form-control" value="{{ $product->code }}" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label" style="color:firebrick;">Nama Produk</label>
            <input type="text" class="form-control" value="{{ $product->name }}" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label" style="color:firebrick;">Stok Saat Ini</label>
            <input type="text" class="form-control" value="{{ $product->stock }}" readonly>
        </div>
        <div class="mb-3">
            <label for="jumlah_stok" class="form-label" style="color:firebrick;">Jumlah Stok yang Ditambahkan</label>
            <input type="number" min="1" name="jumlah_stok" id="jumlah_stok"
                class="form-control @error('jumlah_stok') is-invalid @enderror" required>
            @error('jumlah_stok')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn" style="background:firebrick; color:white;">Tambah Stok</button>
            <a href="{{ route('admin.stock.index') }}" class="btn btn-light">Batal</a>
        </div>
    </form>
    {{-- Footer --}}
        <x-app.footer />
</div>
@endsection
