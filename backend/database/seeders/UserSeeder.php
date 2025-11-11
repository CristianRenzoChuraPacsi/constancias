<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin Global
        $super = User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'password' => Hash::make('admin12345'),
            'tenant_id' => null,
        ]);
        $super->assignRole('super_admin');

        // Admin Empresa A
        $empresaA = User::create([
            'name' => 'Admin Empresa A',
            'email' => 'admin@empresaa.com',
            'password' => Hash::make('passworda'),
            'tenant_id' => 1,
        ]);
        $empresaA->assignRole('admin');

        // Admin Empresa B
        $empresaB = User::create([
            'name' => 'Admin Empresa B',
            'email' => 'admin@empresab.com',
            'password' => Hash::make('passwordb'),
            'tenant_id' => 2,
        ]);
        $empresaB->assignRole('admin');
    }
}
