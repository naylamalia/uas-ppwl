{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\customer\cart\checkout.blade.php --}}
@extends('layouts.customer')
@section('title', 'Konfirmasi Checkout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-firebrick"><i class="bi bi-bag-check"></i> Konfirmasi Pesanan</h2>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($itemsToOrder) && count($itemsToOrder) > 0)
        <div class="table-responsive shadow rounded-3 overflow-hidden">
            <table class="table align-middle mb-0">
                <thead style="background:#fff5f5;" class="text-center">
                    <tr>
                        <th style="width: 40%;">Nama Produk</th>
                        <th style="width: 15%;">Harga</th>
                        <th style="width: 10%;">Jumlah</th>
                        <th style="width: 15%;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach($itemsToOrder as $item)
                        @php $grandTotal += $item['price'] * $item['quantity']; @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-light rounded" style="width:60px; height:60px; display:flex; align-items:center; justify-content:center;">
                                        <i class="bi bi-box-seam fs-3" style="color:#B22222;"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $item['name'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="text-center">{{ $item['quantity'] }}</td>
                            <td class="text-end fw-semibold text-firebrick">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background:#fff5f5;">
                        <td colspan="2" class="text-end fw-bold">Grand Total</td>
                        <td colspan="2" class="text-end fw-bold text-firebrick">Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <!-- Tombol trigger modal -->
            <button type="button" class="btn btn-firebrick btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#alamatModal">
                <i class="bi bi-bag-check"></i> Konfirmasi & Buat Pesanan
            </button>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x fs-1 text-muted"></i>
            <p class="mt-3 text-muted">Tidak ada produk yang dipilih untuk checkout.</p>
            <a href="{{ route('customer.cart.index') }}" class="btn btn-firebrick">
                <i class="bi bi-arrow-left"></i> Kembali ke Keranjang
            </a>
        </div>
    @endif
</div>

<!-- Modal Input Alamat -->
<div class="modal fade" id="alamatModal" tabindex="-1" aria-labelledby="alamatModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('customer.cart.checkout.confirm') }}" method="POST">
      @csrf
      @foreach($itemsToOrder as $item)
        <input type="hidden" name="selected_products[]" value="{{ $item['product_id'] }}">
      @endforeach
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="alamatModalLabel">Isi Alamat Pengiriman</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Lengkap</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="catatan" class="form-label">Catatan (Opsional)</label>
            <input type="text" class="form-control" id="catatan" name="catatan">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-firebrick">Simpan & Pesan</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('styles')
<style>
.text-firebrick {
    color: #B22222 !important;
}
.btn-firebrick, .btn-outline-firebrick {
    border-color: #B22222 !important;
    color: #fff !important;
    background: #B22222 !important;
}
.btn-outline-firebrick {
    background: #fff !important;
    color: #B22222 !important;
}
.btn-firebrick:hover, .btn-outline-firebrick:hover, .btn-firebrick:focus, .btn-outline-firebrick:focus {
    background: #e35dd2 !important;
    color: #fff !important;
    border-color: #e35dd2 !important;
}
.table thead th, .table tfoot tr {
    vertical-align: middle;
}
.table td, .table th {
    vertical-align: middle;
}
</style>
@endpush