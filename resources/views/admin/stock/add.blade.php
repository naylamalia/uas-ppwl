{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\admin\stock\add.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Stok Produk')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white" style="background-color: firebrick;">
                    <h5 class="mb-0 fw-semibold"> Tambah Stok Produk</h5>
                </div>
                <div class="card-body">

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

                    <form action="{{ route('admin.stock.add', $product->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Kode Produk</label>
                            <input type="text" class="form-control" value="{{ $product->code }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" value="{{ $product->name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok Saat Ini</label>
                            <input type="text" class="form-control" value="{{ $product->stock }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_stok" class="form-label">Jumlah Stok yang Ditambahkan</label>
                            <input type="number" min="1" name="jumlah_stok" id="jumlah_stok"
                                class="form-control @error('jumlah_stok') is-invalid @enderror" required>
                            @error('jumlah_stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.stock.index') }}" class="btn btn-outline-secondary">⬅ Kembali</a>
                            <button type="submit" class="btn text-white" style="background-color: firebrick;">
                                 Tambah Stok
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
