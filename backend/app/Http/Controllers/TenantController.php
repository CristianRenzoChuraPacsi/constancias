<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all();

        return response()->json([
            'status'  => 'success',
            'message' => 'Tenants obtenidos correctamente',
            'data'    => $tenants
        ]);
    }

    public function show(Tenant $tenant)
    {
        return response()->json([
            'status' => 'success',
            'data'   => $tenant
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ruc'          => 'required|string|unique:tenants',
            'razon_social' => 'required|string|max:255',
            'siglas'       => 'nullable|string|max:50',
            'nombre'       => 'nullable|string|max:255',
        ]);

        $tenant = Tenant::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Tenant creado correctamente',
            'data'    => $tenant
        ], 201);
    }

    public function update(Request $request, Tenant $tenant)
    {
        $data = $request->validate([
            'ruc'          => 'sometimes|string|unique:tenants,ruc,' . $tenant->id,
            'razon_social' => 'sometimes|string|max:255',
            'siglas'       => 'nullable|string|max:50',
            'nombre'       => 'nullable|string|max:255',
        ]);

        $tenant->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Tenant actualizado correctamente',
            'data'    => $tenant
        ]);
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Tenant eliminado correctamente'
        ]);
    }
}
