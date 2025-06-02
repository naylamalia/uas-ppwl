@extends('layouts.admin')

@section('title', 'Dashboard Admin')

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
        {{-- Greeting Section --}}
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
                    $userName = auth()->user()->name ?? 'Admin';
                @endphp

                <div class="mb-md-0 mb-3 d-flex align-items-center gap-2">
                    <i class="bi {{ $icon }}" style="font-size:2rem; color: {{ $iconColor }}"></i>
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
                            <i class="bi bi-cash-stack" style="font-size:2.5rem; line-height:1;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0" style="color:firebrick;">Total Revenue</h6>
                            <h3 class="mb-0 text-dark">Rp{{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
                            <p class="text-sm mb-0 text-secondary">Total belanjaan produk</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border" style="border-color:firebrick;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon icon-shape rounded-circle me-3 d-flex justify-content-center"
                            style="width:64px; height:64px; background:firebrick; color:white;">
                            <i class="bi bi-receipt" style="font-size:2.5rem; line-height:1;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0" style="color:firebrick;">Total Order</h6>
                            <h3 class="mb-0 text-dark">{{ $orderCount ?? 0 }}</h3>
                            <p class="text-sm mb-0 text-secondary">Jumlah transaksi order</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border" style="border-color:firebrick;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon icon-shape rounded-circle me-3 d-flex justify-content-center"
                            style="width:64px; height:64px; background:firebrick; color:white;">
                            <i class="bi bi-graph-up" style="font-size:2.5rem; line-height:1;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0" style="color:firebrick;">Rata-rata Order</h6>
                            <h3 class="mb-0 text-dark">Rp{{ number_format($avgTransaction ?? 0, 0, ',', '.') }}</h3>
                            <p class="text-sm mb-0 text-secondary">Rata-rata nilai transaksi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Produk Terbaru Dibeli --}}
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-xs border" style="background:#fff5f5; border-color:firebrick;">
                    <div class="card-header border-bottom pb-0" style="background:#fff5f5; border-color:firebrick;">
                        <h6 class="fw-bold fs-4 mb-0" style="color:firebrick;">Produk Terbaru Dibeli</h6>
                        <p class="text-sm mb-3 text-secondary">Daftar produk yang baru saja dibeli</p>
                    </div>
                    <div class="card-body px-0 py-0">
                        <div class="table-responsive w-100 p-0">
                            <table class="table align-items-center mb-0 w-100">
                                <thead>
                                    <tr>
                                        <th style="width:30%; color:white; background:firebrick;" class="text-center">Produk</th>
                                        <th style="width:20%; color:white; background:firebrick;" class="text-center">Pembeli</th>
                                        <th style="width:25%; color:white; background:firebrick;" class="text-center">Tanggal</th>
                                        <th style="width:25%; color:white; background:firebrick;" class="text-center">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders ?? [] as $order)
                                        @foreach($order->products as $product)
                                            <tr>
                                                <td class="text-center">
                                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/img/no-image.png') }}"
                                                         alt="produk" width="36" height="36"
                                                         class="rounded me-2 border" style="object-fit:cover; border-color:firebrick;">
                                                    <span>{{ $product->name ?? '-' }}</span>
                                                </td>
                                                <td class="text-center">{{ $order->user->name ?? '-' }}</td>
                                                <td class="text-center">{{ $order->created_at ? $order->created_at->format('d-m-Y H:i') : '-' }}</td>
                                                <td style="color:firebrick;" class="text-center text-success fw-bold">
                                                    Rp{{ number_format($product->pivot->price * $product->pivot->quantity, 0, ',', '.') }}
                                                    <br>
                                                    <span class="badge bg-secondary">x{{ $product->pivot->quantity }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center" style="color:firebrick;">Belum ada transaksi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <x-app.footer />
    </div>
</main>
@endsection