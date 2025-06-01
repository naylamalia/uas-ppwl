@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold" style="color:firebrick; display:flex; align-items:center; gap:8px;">
        <i class="bi bi-people"></i>Manajemen Pengguna</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.users-management.create') }}" class="btn" style="background:forestgreen; color:white;">
            <i class="bi bi-plus" style="font-size:1.2rem; vertical-align:middle;"></i> Tambah User
        </a>
    </div>

    <div class="card shadow-sm" style="border-color:firebrick; background:#fff5f5;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:firebrick;">
                        <tr>
                            <th style="color:white;" class="text-center">#</th>
                            <th style="color:white;" class="text-center">Nama</th>
                            <th style="color:white;" class="text-center">Email</th>
                            <th style="color:white;" class="text-center">Role</th>
                            <th style="color:white;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center">{{ $user->email }}</td>
                                <td class="text-center">
                                    @foreach($user->roles as $role)
                                        @if($role->name === 'admin')
                                            <span class="badge" style="background:firebrick; color:white;">{{ ucfirst($role->name) }}</span>
                                        @elseif($role->name === 'customer')
                                            <span class="badge" style="background:#ffb3b3; color:firebrick;">{{ ucfirst($role->name) }}</span>
                                        @else
                                            <span class="badge bg-secondary text-white">{{ ucfirst($role->name) }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.users-management.edit', $user->id) }}" class="btn btn-sm p-2 m-2" style="background:chocolate; color:white;">
                                        <i class="bi bi-pencil" style="font-size:1.1rem; vertical-align:middle;"></i> Edit
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-delete-user p-2 m-2"
                                        style="background:firebrick; color:white;"
                                        data-user-id="{{ $user->id }}"
                                        data-user-name="{{ $user->name }}">
                                        <i class="bi bi-trash" style="font-size:1.1rem; vertical-align:middle;"></i> Hapus
                                    </button>
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users-management.destroy', $user->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-person-x"></i> Tidak ada user ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Custom Delete Modal -->
<div class="modal" tabindex="-1" id="deleteUserModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3);">
    <div style="background:#fff; max-width:350px; margin:10% auto; border-radius:8px; box-shadow:0 2px 8px #0002; padding:24px; text-align:center;">
        <div class="mb-3">
            <i class="bi bi-exclamation-triangle" style="font-size:2.5rem; color:firebrick;"></i>
        </div>
        <div class="mb-3">
            <div class="fw-bold mb-2" id="deleteUserModalText">Yakin ingin menghapus user ini?</div>
        </div>
        <div class="d-flex justify-content-center gap-2">
            <button type="button" id="cancelDeleteUser" class="btn btn-secondary btn-sm px-4">Batal</button>
            <button type="button" id="confirmDeleteUser" class="btn btn-danger btn-sm px-4">Hapus</button>
        </div>
    </div>
</div>

<script>
    let selectedUserId = null;
    document.querySelectorAll('.btn-delete-user').forEach(function(btn) {
        btn.addEventListener('click', function() {
            selectedUserId = this.getAttribute('data-user-id');
            const userName = this.getAttribute('data-user-name');
            document.getElementById('deleteUserModalText').innerText = `Yakin ingin menghapus user "${userName}"?`;
            document.getElementById('deleteUserModal').style.display = 'block';
        });
    });

    document.getElementById('cancelDeleteUser').onclick = function() {
        document.getElementById('deleteUserModal').style.display = 'none';
        selectedUserId = null;
    };

    document.getElementById('confirmDeleteUser').onclick = function() {
        if(selectedUserId) {
            document.getElementById('delete-form-' + selectedUserId).submit();
        }
    };

    // Optional: close modal if click outside modal box
    document.getElementById('deleteUserModal').addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
</script>
@endsection