<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-md-flex align-items-center mb-3 mx-2">
                        <div class="mb-md-0 mb-3">
                            <h3 class="font-weight-bold mb-0">Hello, {{ auth()->user()->name ?? 'Customer' }}</h3>
                            <p class="mb-0">Temukan produk terbaik untuk Anda!</p>
                        </div>
                        <form method="GET" action="{{ route('customer.dashboard') }}" class="ms-md-auto mb-sm-0 mb-2 me-2">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Cari produk..." value="{{ request('q') }}">
                                <button class="btn btn-dark" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr class="my-0">

            {{-- Hasil Pencarian --}}
            @if(!empty(request('q')) && $searchResults !== null && $searchResults->isNotEmpty())
                <div class="row my-4">
                    <div class="col-12">
                        <h5>Hasil pencarian untuk: <strong>{{ request('q') }}</strong></h5>
                        <div class="row">
                            @forelse($searchResults as $product)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ $product->image ?? '/assets/img/no-image.png' }}" class="card-img-top" alt="{{ $product->name }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text">Rp{{ number_format($product->price,0,',','.') }}</p>
                                            <a href="{{ route('customer.products.show', $product->id) }}" class="btn btn-primary btn-sm">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p>Tidak ada produk ditemukan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif

            {{-- Produk Terbaru --}}
            <div class="row my-4">
                <div class="col-12">
                    <h5>Produk Terbaru</h5>
                    <div class="row">
                        @foreach($latestProducts as $product)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="{{ $product->image ?? '/assets/img/no-image.png' }}" class="card-img-top" alt="{{ $product->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">Rp{{ number_format($product->price,0,',','.') }}</p>
                                        <a href="{{ route('customer.products.show', $product->id) }}" class="btn btn-primary btn-sm">Detail</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Produk Populer --}}
            <div class="row my-4">
                <div class="col-12">
                    <h5>Produk Populer</h5>
                    <div class="row">
                        @forelse($popularProducts as $product)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="{{ $product->image ?? '/assets/img/no-image.png' }}" class="card-img-top" alt="{{ $product->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">Rp{{ number_format($product->price,0,',','.') }}</p>
                                        <a href="{{ route('customer.products.show', $product->id) }}" class="btn btn-primary btn-sm">Detail</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p>Tidak ada produk populer.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <x-app.footer />
        </div>
    </main>
</x-app-layout>
