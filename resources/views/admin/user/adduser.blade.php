@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold" style="color:firebrick;">Tambah User Baru</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users-management.store') }}" method="POST" class="card p-4 shadow-sm" style="border-color:firebrick; background:#fff5f5;">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label" style="color:firebrick;">Nama</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label" style="color:firebrick;">Email</label>
            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label" style="color:firebrick;">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label" style="color:firebrick;">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label" style="color:firebrick;">Role</label>
            <select name="role" id="role" class="form-select" required>
                <option value="">-- Pilih Role --</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn" style="background:firebrick; color:white;">Tambah User</button>
            <a href="{{ route('admin.users-management.index') }}" class="btn btn-light">Kembali</a>
        </div>
    </form>
</div>
{{-- Footer --}}
        <x-app.footer />
@endsection