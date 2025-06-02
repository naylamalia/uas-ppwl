{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\admin\products\edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold" style="color:firebrick;">Edit Produk</h2>
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm" style="border-color:firebrick; background:#fff5f5;">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="code" class="form-label" style="color:firebrick;">Kode Produk</label>
            <input type="text" class="form-control" id="code" name="code" required value="{{ old('code', $product->code) }}" readonly>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label" style="color:firebrick;">Nama Produk</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $product->name) }}">
            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category" class="form-label" style="color:firebrick;">Kategori</label>
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
            <label for="price" class="form-label" style="color:firebrick;">Harga</label>
            <input type="number" class="form-control" id="price" name="price" required value="{{ old('price', $product->price) }}">
            @error('price')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label" style="color:firebrick;">Stok</label>
            <input type="number" class="form-control" id="stock" name="stock" required value="{{ old('stock', $product->stock) }}">
            @error('stock')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label" style="color:firebrick;">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label" style="color:firebrick;">Gambar Produk</label>
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
        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn" style="background:firebrick; color:white;">Update</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-light">Batal</a>
        </div>
    </form>
</div>
{{-- Footer --}}
        <x-app.footer />
@endsection