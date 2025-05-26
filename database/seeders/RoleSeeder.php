<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $customerRole = Role::create(['name' => 'customer']);

        // Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123')
        ]);
        $admin->assignRole($adminRole);

        // Customer
        $customer = User::create([
            'name' => 'John Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('customer123')
        ]);
        $customer->assignRole($customerRole);
    }
}
