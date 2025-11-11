<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::create([
            'siglas' => 'EMP_A',
            'nombre' => 'AROMA',
            'razon_social' => 'Empresa Aroma',
            'ruc' => '20123456789',
            'direccion' => 'Av. Principal 123',
            'telefono' => '987654321'
        ]);

        Tenant::create([
            'siglas' => 'EMP_B',
            'nombre' => 'LAS TORRES',
            'razon_social' => 'Empresa las Torres',
            'ruc' => '20987654321',
            'direccion' => 'Jr. Comercio 456',
            'telefono' => '912345678'
        ]);
    }
}
