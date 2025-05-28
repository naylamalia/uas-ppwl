{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\Customer\Product\show.blade.php --}}
@extends('layouts.customer')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-5">
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height:300px;">
                    <span class="text-muted">Tidak ada gambar</span>
                </div>
            @endif
        </div>
        <div class="col-md-7">
            <h2 class="fw-bold">{{ $product->name }}</h2>
            <p>Kategori: <span class="badge bg-info text-dark">{{ ucfirst($product->category) }}</span></p>
            <h4 class="text-danger mb-3">Rp{{ number_format($product->price, 0, ',', '.') }}</h4>
            <p>{{ $product->description }}</p>
            <div class="mb-3">
                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                    {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Stok Habis' }}
                </span>
            </div>
            {{-- Form tambah ke cart --}}
            @if($product->stock > 0)
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex align-items-center gap-2 mb-3">
                @csrf
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control w-auto" style="max-width:80px;" required>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                </button>
            </form>
            @else
            <div class="alert alert-warning p-2">Stok produk habis, tidak bisa dipesan.</div>
            @endif
        </div>
    </div>

    <hr>
    <div class="row mt-4">
        <div class="col-md-7">
            <h4>Ulasan Pelanggan</h4>
            @forelse ($product->reviews as $review)
                <div class="border p-3 rounded mb-3">
                    <strong>{{ $review->user->name }}</strong>
                    <p class="mb-1">{{ $review->content }}</p>
                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                </div>
            @empty
                <p>Belum ada ulasan untuk produk ini.</p>
            @endforelse
        </div>
        <div class="col-md-5">
            {{-- Form tambah review --}}
            @auth
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-2">Tulis Ulasan</h5>
                    <form action="{{ route('customer.products.review', $product->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <textarea name="content" class="form-control" rows="3" placeholder="Tulis ulasan Anda..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Kirim Ulasan</button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </div>
</div>
@endsection