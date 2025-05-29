@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <h2 class="mb-5 fw-bold text-primary">
        <i class="bi bi-receipt"></i> Detail Order
    </h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-5 mb-5">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="mb-3 fs-5"><strong>No. Pesanan:</strong> <span class="text-secondary">#{{ $order->id }}</span></div>
                    <div class="mb-3 fs-5"><strong>Pelanggan:</strong> <span class="text-secondary">{{ $order->user->name ?? '-' }}</span></div>
                    <div class="mb-3 fs-5"><strong>Tanggal Pesan:</strong> <span class="text-secondary">{{ $order->created_at->format('d M Y H:i') }}</span></div>
                </div>
                <div class="col-md-6 d-flex flex-column justify-content-between">
                    <div class="mb-3 fs-5">
                        <strong>Status:</strong>
                        <span class="badge
                            @if($order->status_order == 'belum_selesai') bg-warning text-dark
                            @elseif($order->status_order == 'selesai') bg-success
                            @elseif($order->status_order == 'dibatalkan') bg-danger
                            @else bg-secondary
                            @endif
                            fs-6 px-3 py-2 rounded-pill"
                        >
                            {{ ucfirst(str_replace('_', ' ', $order->status_order)) }}
                        </span>
                    </div>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-flex align-items-center gap-3">
                        @csrf
                        @method('PATCH')
                        <label for="status_order" class="form-label mb-0 fw-semibold">Ubah Status:</label>
                        <select name="status_order" id="status_order" class="form-select form-select-sm w-auto" required>
                            <option value="belum_selesai" {{ $order->status_order == 'belum_selesai' ? 'selected' : '' }}>Belum Selesai</option>
                            <option value="selesai" {{ $order->status_order == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $order->status_order == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm px-4">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-5">
        <div class="card-header bg-primary text-white fw-bold fs-5 d-flex align-items-center gap-2 rounded-top">
            <i class="bi bi-box-seam fs-4"></i> Produk Dipesan
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary fs-6">
                    <tr>
                        <th>Nama Produk</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end">Harga Satuan</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-semibold">{{ $order->product->name ?? '-' }}</td>
                        <td class="text-center">{{ $order->quantity }}</td>
                        <td class="text-end">Rp{{ number_format($order->price / max($order->quantity, 1), 0, ',', '.') }}</td>
                        <td class="text-end fw-bold text-primary">Rp{{ number_format($order->price, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="table-light fs-5 fw-bold">
                        <th colspan="3" class="text-end">Total</th>
                        <th class="text-end text-primary">Rp{{ number_format($order->price ?? $order->total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection