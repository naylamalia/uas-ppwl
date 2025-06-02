@extends('components.app.navbar')
@section('title', 'Daftar Keranjang Belanja')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw1-bold text-firebrick"><i class="bi bi-cart"></i> Keranjang Belanja</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="table-responsive shadow rounded-3 overflow-hidden">
            <table class="table align-middle mb-0">
                <thead style="background:#fff0f6;" class="text-center">
                    <tr>
                        <th style="width: 5%;">
                            <input type="checkbox" id="selectAll">
                        </th>
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
                                <input type="checkbox" name="selected_products[]" value="{{ (int)$item['product_id'] }}" form="checkoutForm">
                            </td>
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
                            <td class="text-center text-success fw-bold">Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="text-center">
                                <!-- Form decrement -->
                                <form action="{{ route('customer.cart.update', (int)$item['product_id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="action" value="decrement">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary px-2 py-1" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                        <i class="bi bi-dash"></i>
                                    </button>
                                </form>
                                <span class="mx-2">{{ $item['quantity'] }}</span>
                                <!-- Form increment -->
                                <form action="{{ route('customer.cart.update', (int)$item['product_id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="action" value="increment">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary px-2 py-1">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="text-center fw-semibold text-success">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                            <td class="text-center">
                                <!-- Tombol hapus, gunakan modal bukan form inline -->
                                <button type="button" class="btn btn-outline-firebrick btn-sm rounded-circle" title="Hapus"
                                    onclick="showDeleteModal('{{ route('customer.cart.remove', (int)$item['product_id']) }}', '{{ $item['name'] }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background:#fff0f6;">
                        <td></td>
                        <td></td>
                        <td colspan="2" class="text-end fw-bold">Total</td>
                        <td class="text-center fw-bold text-success">Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- Form checkout hanya untuk tombol checkout -->
        <form id="checkoutForm" action="{{ route('customer.cart.checkout') }}" method="POST">
            @csrf
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-firebrick btn-lg shadow-sm">
                    <i class="bi bi-bag-check"></i> Checkout Produk Terpilih
                </button>
            </div>
        </form>
    @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x fs-1 text-muted"></i>
            <p class="mt-3 text-muted">Keranjang belanja kosong.</p>
            <a href="{{ route('customer.products.index') }}" class="btn btn-firebrick">
                <i class="bi bi-arrow-left"></i> Belanja Sekarang
            </a>
        </div>
    @endif
</div>

{{-- Modal Hapus --}}
<div class="modal" tabindex="-1" id="deleteCartModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3);">
    <div style="background:#fff; max-width:350px; margin:10% auto; border-radius:8px; box-shadow:0 2px 8px #0002; padding:24px; text-align:center;">
        <div class="mb-3">
            <i class="bi bi-trash" style="font-size:2.5rem; color:#B22222;"></i>
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
.text-firebrick { color: firebrick !important; }
.btn-firebrick, .btn-outline-firebrick { border-color: firebrick !important; color: #fff !important; background: firebrick !important; }
.btn-outline-firebrick { background: #fff !important; color: firebrick !important; }
.btn-firebrick:hover, .btn-outline-firebrick:hover, .btn-firebrick:focus, .btn-outline-firebrick:focus { background: #b22222 !important; color: #fff !important; border-color: #b22222 !important; }
.table thead th, .table tfoot tr { vertical-align: middle; }
.table td, .table th { vertical-align: middle; }
.table thead { background: #B22222 !important; }
.table thead th { background: #B22222 !important; color: #fff !important; }
</style>
@endpush

@push('scripts')
<script>
document.getElementById('selectAll').onclick = function() {
    let checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
    for (let cb of checkboxes) cb.checked = this.checked;
};
function showDeleteModal(action, name) {
    document.getElementById('deleteCartForm').action = action;
    document.getElementById('deleteCartProductName').innerText = name;
    document.getElementById('deleteCartModal').style.display = 'block';
}
document.getElementById('cancelDeleteCart').onclick = function() {
    document.getElementById('deleteCartModal').style.display = 'none';
};
// Optional: close modal if click outside modal box
document.getElementById('deleteCart1Modal').onclick = function(e) {
    if (e.target === this) this.style.display = 'none';
};
</script>
@endpush