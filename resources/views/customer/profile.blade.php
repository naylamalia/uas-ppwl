{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\Customer\profile.blade.php --}}
@extends('layouts.customer')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-firebrick"><i class="bi bi-person-circle"></i> Profil Saya</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 text-center">
                            <i class="bi bi-person-circle fs-1 text-firebrick"></i>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">No. HP</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone ?? $customer->phone ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Alamat</label>
                            <textarea name="location" id="location" class="form-control" rows="2">{{ old('location', $user->location) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="about" class="form-label">Tentang Anda</label>
                            <textarea name="about" id="about" class="form-control" rows="2">{{ old('about', $user->about) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat Lengkap</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $customer->address ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth', $customer->date_of_birth ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="">Pilih</option>
                                <option value="male" {{ old('gender', $customer->gender ?? '') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', $customer->gender ?? '') == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-firebrick">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.text-firebrick {
    color: firebrick !important;
}
.btn-firebrick {
    border-color: firebrick !important;
    color: #fff !important;
    background: firebrick !important;
}
.btn-firebrick:hover, .btn-firebrick:focus {
    background: #b22222 !important;
    color: #fff !important;
    border-color: #b22222 !important;
}
</style>
@endpush