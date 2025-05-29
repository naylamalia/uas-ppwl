@extends('layouts.admin')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-md-12">
                    @php
                        $hour = now()->format('H');
                        if ($hour >= 5 && $hour < 12) {
                            $greeting = 'Selamat pagi';
                        } elseif ($hour >= 12 && $hour < 15) {
                            $greeting = 'Selamat siang';
                        } elseif ($hour >= 15 && $hour < 18) {
                            $greeting = 'Selamat sore';
                        } else {
                            $greeting = 'Selamat malam';
                        }
                        \Carbon\Carbon::setLocale('id');
                        $hari = \Carbon\Carbon::now()->translatedFormat('l, d F Y');
                    @endphp

                    <div class="mb-md-0 mb-3">
                        <h3 class="font-weight-bold mb-0" style="color:firebrick;">{{ $greeting }}, Admin</h3>
                        <div class="text-secondary mt-1" style="font-size:1rem;">
                            Hari ini: <span style="color:firebrick;">{{ $hari }}</span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Statistik --}}
            <div class="row my-4">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border" style="border-color:firebrick; background:#fff5f5;">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon icon-shape rounded-circle me-3 d-flex justify-content-center"
                                style="width:64px; height:64px; background:firebrick; color:white;">
                                <i class="bi bi-cash-stack" style="font-size:2.5rem; line-height:1;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0" style="color:firebrick;">Total Revenue</h6>
                                <h3 class="mb-0 text-dark">Rp{{ number_format($totalRevenue ?? 0,0,',','.') }}</h3>
                                <p class="text-sm mb-0 text-secondary">Total nilai pembelanjaan produk</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border" style="border-color:firebrick; background:#fff5f5;">
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
                    <div class="card border" style="border-color:firebrick; background:#fff5f5;">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon icon-shape rounded-circle me-3 d-flex justify-content-center"
                                style="width:64px; height:64px; background:firebrick; color:white;">
                                <i class="bi bi-graph-up" style="font-size:2.5rem; line-height:1;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0" style="color:firebrick;">Rata-rata Order</h6>
                                <h3 class="mb-0 text-dark">Rp{{ number_format($avgTransaction ?? 0,0,',','.') }}</h3>
                                <p class="text-sm mb-0 text-secondary">Rata-rata nilai transaksi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Recent Transaction --}}
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card shadow-xs border" style="background:#fff5f5; border-color:firebrick;">
                        <div class="card-header border-bottom pb-0" style="background:#fff5f5; border-color:firebrick;">
                            <h6 class="fw-bold fs-4 mb-0" style="color:firebrick;">Produk Terbaru Dibeli</h6>
                            <p class="text-sm mb-3 text-secondary">Daftar produk yang baru saja dibeli</p>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="table-responsive w-100 p-0" style="background:#fff5f5;">
                                <table class="table align-items-center mb-0 w-100" style="background:#fff5f5;">
                                    <thead>
                                        <tr>
                                            <th style="width:30%; color:white; background:firebrick;">Produk</th>
                                            <th style="width:20%; color:white; background:firebrick;">Pembeli</th>
                                            <th style="width:25%; color:white; background:firebrick;">Tanggal</th>
                                            <th style="width:25%; color:white; background:firebrick;">Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody style="background:#fff5f5;">
                                        {{-- Check if there are recent orders --}}
                                        {{-- Loop through recent orders --}}
                                        @forelse($recentOrders ?? [] as $order)
                                            <tr>
                                                <td class="d-flex align-items-center">
                                                    <img src="{{ $order->product->image_url ?? asset('assets/img/no-image.png') }}" alt="produk" width="36" height="36" class="rounded me-2 border" style="object-fit:cover; border-color:firebrick;">
                                                    <span>{{ $order->product->name ?? '-' }}</span>
                                                </td>
                                                <td>{{ $order->user->name ?? '-' }}</td>
                                                <td>{{ $order->created_at ? $order->created_at->format('d-m-Y H:i') : '-' }}</td>
                                                <td style="color:firebrick;">Rp{{ number_format($order->price,0,',','.') }}</td>
                                            </tr>
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
            <x-app.footer />
        </div>
    </main>
@endsection