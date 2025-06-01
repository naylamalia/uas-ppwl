{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\Customer\cart\index.blade.php --}}
@extends('layouts.customer')
@section('title', 'Daftar Keranjang Belanja')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-firebrick"><i class="bi bi-cart"></i> Keranjang Belanja</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="table-responsive shadow rounded-3 overflow-hidden">
            <table class="table align-middle mb-0">
                <thead style="background:#fff5f5;" class="text-center">
                    <tr>
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
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-light rounded" style="width:60px; height:60px; display:flex; align-items:center; justify-content:center;">
                                        <i class="bi bi-box-seam fs-3" style="color:firebrick;"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $item['name'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="text-center">{{ $item['quantity'] }}</td>
                            <td class="text-end fw-semibold text-firebrick">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                            <td class="text-center">
                                <form action="{{ route('customer.cart.remove', $item['product_id']) }}" method="POST" onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-firebrick btn-sm rounded-circle" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background:#fff5f5;">
                        <td colspan="3" class="text-end fw-bold">Grand Total</td>
                        <td class="text-end fw-bold text-firebrick">Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('customer.orders.index') }}" class="btn btn-firebrick btn-lg shadow-sm">
                <i class="bi bi-bag-check"></i> Checkout
            </a>
        </div>
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
@endsection

@push('styles')
<style>
.text-firebrick {
    color: firebrick !important;
}
.btn-firebrick, .btn-outline-firebrick {
    border-color: firebrick !important;
    color: #fff !important;
    background: firebrick !important;
}
.btn-outline-firebrick {
    background: #fff !important;
    color: firebrick !important;
}
.btn-firebrick:hover, .btn-outline-firebrick:hover, .btn-firebrick:focus, .btn-outline-firebrick:focus {
    background: #b22222 !important;
    color: #fff !important;
    border-color: #b22222 !important;
}
.table thead th, .table tfoot tr {
    vertical-align: middle;
}
.table td, .table th {
    vertical-align: middle;
}
</style>
@endpush