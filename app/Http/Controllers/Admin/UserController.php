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
        return view('laravel-examples.users-management', compact('users'));
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
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
        ]);

        // Assign role via Spatie
        $user->assignRole($request->role);

        return redirect()->route('users-management')->with('success', 'New member added successfully.');
    }
}