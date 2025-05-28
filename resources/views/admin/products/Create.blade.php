{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\admin\product\addproduct.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="container mt-4">
    <h2>Tambah Produk</h2>
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select class="form-control" id="category" name="category" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            @error('category')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" class="form-control" id="price" name="price" required value="{{ old('price') }}">
            @error('price')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stock" name="stock" required value="{{ old('stock') }}">
            @error('stock')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Produk</label>
            <input type="file" class="form-control" id="image" name="image">
            @error('image')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection