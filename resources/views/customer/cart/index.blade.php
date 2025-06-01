{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\Customer\cart\index.blade.php --}}
@extends('layouts.customer')
@section('title', 'Daftar Keranjang Belanja')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-pink"><i class="bi bi-cart"></i> Keranjang Belanja</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(count($cart) > 0)
        <form action="{{ route('customer.cart.checkout') }}" method="POST">
            @csrf
            <div class="table-responsive shadow rounded-3 overflow-hidden">
                <table class="table align-middle mb-0">
                    <thead style="background:#d63384;" class="text-white text-center">
                        <tr>
                            <th style="width: 5%;"><input type="checkbox" id="select-all"></th>
                            <th style="width: 40%;">Nama Produk</th>
                            <th style="width: 15%;">Harga</th>
                            <th style="width: 10%;">Jumlah</th>
                            <th style="width: 15%;">Total</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @foreach($cart as $item)
                            @php $grandTotal += $item['price'] * $item['quantity']; @endphp
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selected_products[]" value="{{ $item['product_id'] }}" checked>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-light rounded" style="width:60px; height:60px; display:flex; align-items:center; justify-content:center;">
                                            <i class="bi bi-box-seam fs-3" style="color:#ed5aba;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $item['name'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item['quantity'] }}</td>
                                <td class="text-end fw-semibold text-pink">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <!-- Tombol hapus dengan popup -->
                                    <button type="button" class="btn btn-outline-pink btn-sm rounded-circle" title="Hapus"
                                        onclick="showDeleteModal(`{{ route('customer.cart.remove', $item['product_id']) }}`, `{{ $item['name'] }}`)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background:#fff0f6;">
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td class="text-end fw-bold text-pink">Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-pink btn-lg shadow-sm">
                    <i class="bi bi-bag-check"></i> Checkout
                </button>
            </div>
        </form>
    @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x fs-1 text-muted"></i>
            <p class="mt-3 text-muted">Keranjang belanja kosong.</p>
            <a href="{{ route('customer.products.index') }}" class="btn btn-pink">
                <i class="bi bi-arrow-left"></i> Belanja Sekarang
            </a>
        </div>
    @endif
</div>

{{-- Modal Hapus --}}
<div class="modal" tabindex="-1" id="deleteCartModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3);">
    <div style="background:#fff; max-width:350px; margin:10% auto; border-radius:8px; box-shadow:0 2px 8px #0002; padding:24px; text-align:center;">
        <div class="mb-3">
            <i class="bi bi-trash" style="font-size:2.5rem; color:#d63384;"></i>
        </div>
        <div class="mb-3">
            <div class="fw-bold mb-2">Hapus produk dari keranjang?</div>
            <div id="deleteCartProductName" class="text-muted small"></div>
        </div>
        <form id="deleteCartForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="d-flex justify-content-center gap-2">
                <button type="button" id="cancelDeleteCart" class="btn btn-secondary btn-sm px-4">Batal</button>
                <button type="submit" class="btn btn-danger btn-sm px-4">Hapus</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.text-pink {
    color: #ed5aba !important;
}
.btn-pink, .btn-outline-pink {
    border-color: #ed5aba !important;
    color: #fff !important;
    background: #ed5aba !important;
}
.btn-outline-pink {
    background: #fff !important;
    color: #ed5aba !important;
}
.btn-pink:hover, .btn-outline-pink:hover, .btn-pink:focus, .btn-outline-pink:focus {
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
.table thead {
    background: #d63384 !important;
}
.table thead th {
    background: #d63384 !important;
    color: #fff !important;
}
</style>
@endpush

@push('scripts')
<script>
function showDeleteModal(action, name) {
    document.getElementById('deleteCartForm').action = action;
    document.getElementById('deleteCartProductName').innerText = name;
    document.getElementById('deleteCartModal').style.display = 'block';
}
document.getElementById('cancelDeleteCart').onclick = function() {
    document.getElementById('deleteCartModal').style.display = 'none';
};
// Optional: close modal if click outside modal box
document.getElementById('deleteCartModal').onclick = function(e) {
    if (e.target === this) this.style.display = 'none';
};
</script>
@endpush