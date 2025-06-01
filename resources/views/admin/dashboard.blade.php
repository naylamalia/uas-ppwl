@extends('layouts.customer')

@section('title', 'Dashboard Customer')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    body {
        min-height: 100vh;
        background: #fff;
    }
    .card, .card-body {
        background: #fff !important;
    }
    .card-header, .border-bottom {
        background: #fff !important;
        border-color: firebrick !important;
    }
    .card-header h5, .fw-bold, .text-dark, .card-header, .fs-4, .font-weight-bold {
        color: firebrick !important;
    }
    .btn-outline-primary, .btn-outline-danger, .btn-outline-secondary {
        border-color: firebrick !important;
        color: firebrick !important;
    }
    .btn-outline-primary:hover, .btn-outline-danger:hover, .btn-outline-secondary:hover {
        background: firebrick !important;
        color: #fff !important;
    }
    .list-group-item {
        background: #fff !important;
    }
    .border, .card.border {
        border-color: firebrick !important;
    }
    .table th, .table td {
        color: firebrick !important;
    }
</style>
@endpush

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4 px-5">
            {{-- Greeting --}}
            <div class="row">
                <div class="col-md-12">
                    @php
                        $hour = now()->format('H');
                        if ($hour >= 5 && $hour < 12) {
                            $greeting = 'Selamat pagi';
                            $icon = 'bi-sun-fill';
                            $iconColor = '#f59e42';
                        } elseif ($hour >= 12 && $hour < 15) {
                            $greeting = 'Selamat siang';
                            $icon = 'bi-sun-fill';
                            $iconColor = '#f59e42';
                        } elseif ($hour >= 15 && $hour < 18) {
                            $greeting = 'Selamat sore';
                            $icon = 'bi-sunset-fill';
                            $iconColor = '#f59e42';
                        } else {
                            $greeting = 'Selamat malam';
                            $icon = 'bi-moon-stars-fill';
                            $iconColor = '#6c757d';
                        }
                        \Carbon\Carbon::setLocale('id');
                        $hari = \Carbon\Carbon::now()->translatedFormat('l, d F Y');
                        $userName = auth()->user()->name ?? 'Customer';
                    @endphp

                    <div class="mb-md-0 mb-3 d-flex align-items-center gap-2" id="greeting-row">
                        <i class="bi {{ $icon }}" style="font-size:2rem; color: {{ $iconColor }};"></i>
                        <h3 class="font-weight-bold mb-0" style="color:firebrick;">
                            {{ $greeting }}, {{ $userName }}
                        </h3>
                    </div>
                    <div class="text-secondary mt-1" style="font-size:1rem;">
                        Hari ini: <span style="color:firebrick;">{{ $hari }}</span>
                    </div>
                </div>
            </div>

            {{-- Statistik --}}
            <div class="row my-4">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border" style="border-color:firebrick;">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon icon-shape rounded-circle me-3 d-flex justify-content-center"
                                style="width:64px; height:64px; background:firebrick; color:white;">
                                <i class="bi bi-bag-check" style="font-size:2.5rem; line-height:1;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0" style="color:firebrick;">Total Order Saya</h6>
                                <h3 class="mb-0 text-dark">{{ $orderCount ?? 0 }}</h3>
                                <p class="text-sm mb-0 text-secondary">Jumlah order yang pernah dibuat</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border" style="border-color:firebrick;">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon icon-shape rounded-circle me-3 d-flex justify-content-center"
                                style="width:64px; height:64px; background:firebrick; color:white;">
                                <i class="bi bi-cash-stack" style="font-size:2.5rem; line-height:1;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0" style="color:firebrick;">Total Belanja</h6>
                                <h3 class="mb-0 text-dark">Rp{{ number_format($totalSpent ?? 0,0,',','.') }}</h3>
                                <p class="text-sm mb-0 text-secondary">Total uang yang dibelanjakan</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border" style="border-color:firebrick;">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon icon-shape rounded-circle me-3 d-flex justify-content-center"
                                style="width:64px; height:64px; background:firebrick; color:white;">
                                <i class="bi bi-star" style="font-size:2.5rem; line-height:1;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0" style="color:firebrick;">Produk Favorit</h6>
                                <h3 class="mb-0 text-dark">{{ $favoriteCount ?? 0 }}</h3>
                                <p class="text-sm mb-0 text-secondary">Produk yang sering dibeli</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Produk Terbaru --}}
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border">
                        <div class="card-header border-bottom pb-0">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-stars me-2"></i>Produk Terbaru</h5>
                        </div>
                        <div class="card-body">
                            @if($latestProducts->isEmpty())
                                <p class="text-secondary">Belum ada produk terbaru.</p>
                            @else
                                <ul class="list-group list-group-flush">
                                    @foreach ($latestProducts as $product)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $product->name }}</strong>
                                                <br>
                                                <small class="text-secondary">Rp {{ number_format($product->price, 0, ',', '.') }}</small>
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
                    <div class="card border">
                        <div class="card-header border-bottom pb-0">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-fire me-2"></i>Produk Terpopuler</h5>
                        </div>
                        <div class="card-body">
                            @if($popularProducts->isEmpty())
                                <p class="text-secondary">Belum ada produk populer.</p>
                            @else
                                <ul class="list-group list-group-flush">
                                    @foreach ($popularProducts as $product)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $product->name }}</strong>
                                                <br>
                                                <small class="text-secondary">Dilihat {{ $product->views }}x</small>
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
                <div class="card mt-5 border">
                    <div class="card-header border-bottom pb-0">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-search me-2"></i>Hasil Pencarian</h5>
                    </div>
                    <div class="card-body">
                        @if($searchResults->isEmpty())
                            <p class="text-secondary">Tidak ada hasil untuk pencarian Anda.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($searchResults as $product)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $product->name }}</strong>
                                            <br>
                                            <small class="text-secondary">Rp {{ number_format($product->price, 0, ',', '.') }}</small>
                                        </div>
                                        <a href="{{ route('customer.products.show', $product->id) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection