{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\admin\products\edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container mt-4">
    <h2>Edit Produk</h2>
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="code" class="form-label">Kode Produk</label>
            <input type="text" class="form-control" id="code" name="code" required value="{{ old('code', $product->code) }}" readonly>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $product->name) }}">
            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select class="form-control" id="category" name="category" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ old('category', $product->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            @error('category')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" class="form-control" id="price" name="price" required value="{{ old('price', $product->price) }}">
            @error('price')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stock" name="stock" required value="{{ old('stock', $product->stock) }}">
            @error('stock')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Produk</label>
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100">
                </div>
            @endif
            <input type="file" class="form-control" id="image" name="image">
            @error('image')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection