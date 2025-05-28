{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\Customer\products\show.blade.php --}}
@extends('layouts.customer')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top rounded-top" style="object-fit:cover; height:320px;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded-top" style="height:320px;">
                        <span class="text-muted">Tidak ada gambar</span>
                    </div>
                @endif
                <div class="card-body">
                    <h3 class="fw-bold mb-2">{{ $product->name }}</h3>
                    <p class="mb-1">
                        <span class="badge bg-info text-dark">{{ ucfirst($product->category) }}</span>
                        <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} ms-2">
                            {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Stok Habis' }}
                        </span>
                    </p>
                    <h4 class="text-danger mb-3">Rp{{ number_format($product->price, 0, ',', '.') }}</h4>
                    <p class="mb-3">{{ $product->description }}</p>
                    {{-- Form tambah ke cart --}}
                    @if($product->stock > 0)
                    <form action="{{ route('customer.cart.add', $product->id) }}" method="POST" class="d-flex align-items-center gap-2 mb-2">
                        @csrf
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control w-auto" style="max-width:80px;" required>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                        </button>
                    </form>
                    <!-- Tombol Pesan Sekarang (modal) -->
                    <button type="button" class="btn btn-primary w-100 mt-2" data-bs-toggle="modal" data-bs-target="#orderModal">
                        <i class="bi bi-bag-check"></i> Pesan Sekarang
                    </button>
                    <!-- Modal Form Order -->
                    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="{{ route('customer.orders.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="modal-header">
                              <h5 class="modal-title" id="orderModalLabel">Pesan Produk</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="mb-2">
                                <label for="order-quantity" class="form-label">Jumlah</label>
                                <input type="number" name="quantity" id="order-quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}" required>
                              </div>
                              <div class="mb-2">
                                <label for="alamat" class="form-label">Alamat Pengiriman</label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                              </div>
                              <div class="mb-2">
                                <label for="rincian_pemesanan" class="form-label">Catatan/Rincian Pemesanan</label>
                                <textarea name="rincian_pemesanan" id="rincian_pemesanan" class="form-control" rows="2" required>{{ old('rincian_pemesanan') }}</textarea>
                              </div>
                              <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" id="pilihan_cod" name="pilihan_cod">
                                <label class="form-check-label" for="pilihan_cod">
                                  Bayar di Tempat (COD)
                                </label>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary">
                                <i class="bi bi-bag-check"></i> Pesan Sekarang
                              </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    @else
                    <div class="alert alert-warning p-2 mb-0">Stok produk habis, tidak bisa dipesan.</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="fw-semibold mb-3"><i class="bi bi-chat-left-text"></i> Ulasan Pelanggan</h4>
                    @forelse ($product->reviews as $review)
                        <div class="border rounded p-3 mb-3 bg-light">
                            <div class="d-flex align-items-center mb-1">
                                <i class="bi bi-person-circle fs-5 me-2 text-primary"></i>
                                <strong>{{ $review->user->name }}</strong>
                                <span class="ms-auto text-muted small">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="mb-1">
                                @for($i=1; $i<=5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : '' }}"></i>
                                @endfor
                            </div>
                            <p class="mb-0">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3">
                            <i class="bi bi-box-seam"></i> Belum ada ulasan untuk produk ini.
                        </div>
                    @endforelse
                </div>
            </div>
            {{-- Form tambah review --}}
            @auth
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-2"><i class="bi bi-pencil-square"></i> Tulis Ulasan</h5>
                    <form action="{{ route('customer.products.reviews.store', $product->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label for="rating" class="form-label">Rating</label>
                            <select name="rating" id="rating" class="form-control" required>
                                <option value="">Pilih rating</option>
                                @for($i=5; $i>=1; $i--)
                                    <option value="{{ $i }}">{{ $i }} Bintang</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-2">
                            <textarea name="comment" class="form-control" rows="3" placeholder="Tulis ulasan Anda..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-send"></i> Kirim Ulasan
                        </button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-img-top {
        object-fit: cover;
        height: 320px;
    }
    .card {
        border-radius: 1rem;
    }
    .border {
        border-radius: 0.75rem !important;
    }
</style>
@endpush