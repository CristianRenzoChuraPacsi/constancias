<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ========= CREAR ROLES =========
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $operador = Role::firstOrCreate(['name' => 'operador', 'guard_name' => 'web']);
        $consulta = Role::firstOrCreate(['name' => 'consulta', 'guard_name' => 'web']);

        // ========= PERMISOS =========
        $permisos = [
            // USERS
            'users.view','users.create','users.edit','users.delete',

            // ROLES
            'roles.view','roles.create','roles.edit','roles.delete',

            // TENANTS
            'tenants.view','tenants.create','tenants.edit','tenants.delete',

            // CONDUCTORES
            'conductores.view','conductores.create','conductores.edit','conductores.delete',

            // VEHICULOS
            'vehiculos.view','vehiculos.create','vehiculos.edit','vehiculos.delete',

            // RUTAS
            'rutas.view','rutas.create','rutas.edit','rutas.delete',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso, 'guard_name' => 'web']);
        }

        // ========= ASIGNACIÓN DE PERMISOS =========

        // SUPER ADMIN: todos los permisos
        $superAdmin->syncPermissions(Permission::all());

        // ADMIN: CRUD completo de usuarios, conductores, vehículos, rutas, pero no tenants globales
        $admin->syncPermissions([
            'users.view','users.create','users.edit','users.delete',
            'conductores.view','conductores.create','conductores.edit','conductores.delete',
            'vehiculos.view','vehiculos.create','vehiculos.edit','vehiculos.delete',
            'rutas.view','rutas.create','rutas.edit','rutas.delete',
        ]);

        // OPERADOR: solo view, create, edit en conductores, vehículos y rutas
        $operador->syncPermissions([
            'conductores.view','conductores.create','conductores.edit',
            'vehiculos.view','vehiculos.create','vehiculos.edit',
            'rutas.view','rutas.create','rutas.edit',
        ]);

        // CONSULTA: solo view en todos los módulos
        $consulta->syncPermissions([
            'users.view',
            'roles.view',
            'tenants.view',
            'conductores.view',
            'vehiculos.view',
            'rutas.view',
        ]);
    }
}
