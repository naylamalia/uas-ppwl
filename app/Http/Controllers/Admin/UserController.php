<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get(); // menampilkan user beserta rolenya
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.user.adduser', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|min:3|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:7|max:255|confirmed',
            'role'     => 'required|exists:roles,name',
        ], [
            'name.required'     => 'Name is required',
            'email.required'    => 'Email is required',
            'password.required' => 'Password is required',
            'role.required'     => 'Role is required',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role via Spatie
        $user->assignRole($request->role);

        return redirect()->route('admin.users-management.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.user.edituser', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|min:3|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:7|max:255|confirmed',
            'role'     => 'required|exists:roles,name',
        ], [
            'name.required'     => 'Name is required',
            'email.required'    => 'Email is required',
            'role.required'     => 'Role is required',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Sync role
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users-management.index')->with('success', 'Pengguna berhasil diupdate.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jangan hapus user yang sedang login (opsional)
        if (auth()->id() == $user->id) {
            return redirect()->route('admin.users-management.index')->with('error', 'Tidak bisa menghapus user yang sedang login.');
        }

        $user->delete();

        return redirect()->route('admin.users-management.index')->with('success', 'User berhasil dihapus.');
    }
}