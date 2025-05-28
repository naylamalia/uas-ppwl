@extends('layouts.customer')

@section('title', 'Dashboard Customer')

@section('content')
    <div class="row g-4">
        {{-- Produk Terbaru --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-stars me-2"></i>Produk Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($latestProducts->isEmpty())
                        <p class="text-muted">Belum ada produk terbaru.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($latestProducts as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $product->name }}</strong>
                                        <br>
                                        <small class="text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</small>
                                    </div>
                                    <a href="{{ route('customer.products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        {{-- Produk Terpopuler --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-fire me-2"></i>Produk Terpopuler</h5>
                </div>
                <div class="card-body">
                    @if($popularProducts->isEmpty())
                        <p class="text-muted">Belum ada produk populer.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($popularProducts as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $product->name }}</strong>
                                        <br>
                                        <small class="text-muted">Dilihat {{ $product->views }}x</small>
                                    </div>
                                    <a href="{{ route('customer.products.show', $product->id) }}" class="btn btn-sm btn-outline-danger">Detail</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Hasil Pencarian (Jika Ada) --}}
    @if(isset($searchResults))
        <div class="card mt-5 border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-search me-2"></i>Hasil Pencarian</h5>
            </div>
            <div class="card-body">
                @if($searchResults->isEmpty())
                    <p class="text-muted">Tidak ada hasil untuk pencarian Anda.</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($searchResults as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $product->name }}</strong>
                                    <br>
                                    <small class="text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</small>
                                </div>
                                <a href="{{ route('customer.products.show', $product->id) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endif
@endsection