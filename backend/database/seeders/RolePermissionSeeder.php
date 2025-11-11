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
        $secretaria = Role::firstOrCreate(['name' => 'secretaria', 'guard_name' => 'web']);
        $computo = Role::firstOrCreate(['name' => 'computo', 'guard_name' => 'web']);

        // ========= PERMISOS =========
        $permisos = [
            // USERS
            'users.view','users.create','users.edit','users.delete',

            // ROLES
            'roles.view','roles.create','roles.edit','roles.delete',

            // DOCENTES
            'docentes.view','docentes.create','docentes.edit','docentes.delete',

            // ASISTENCIA_DOCENTES
            'asistencia_docentes.view','asistencia_docentes.create','asistencia_docentes.edit','asistencia_docentes.delete',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso, 'guard_name' => 'web']);
        }

        // ========= ASIGNACIÓN DE PERMISOS =========

        // SUPER ADMIN: todos los permisos
        $superAdmin->syncPermissions(Permission::all());

        // ADMIN: CRUD global
        $admin->syncPermissions([
            'users.view','users.create','users.edit','users.delete',
            'docentes.view','docentes.create','docentes.edit','docentes.delete',
            'asistencia_docentes.view','asistencia_docentes.create','asistencia_docentes.edit','asistencia_docentes.delete',
        ]);

        // COMPUTO: docentes
        $computo->syncPermissions([
            'docentes.view','docentes.create','docentes.edit','docentes.delete',
            'asistencia_docentes.view','asistencia_docentes.create','asistencia_docentes.edit','asistencia_docentes.delete',
        ]);

        // CONSULTAS
        $secretaria->syncPermissions([
            'docentes.view',
            'asistencia_docentes.view',
        ]);
    }
}
