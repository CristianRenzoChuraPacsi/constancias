<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    // Vehiculo
    public function index()
    {
        $vehiculos = Vehiculo::all();

        return response()->json([
            'status'  => 'success',
            'message' => 'Vehiculos obtenidos correctamente',
            'data'    => $vehiculos
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa'        => 'required|string|max:20|unique:vehiculos',
            'modelo'       => 'string|max:20',
            'capacidad'    => 'integer|min:1',
        ]);

        $vehiculo = Vehiculo::create([
            'placa'      => $request->placa,
            'modelo'    => $request->modelo,
            'capacidad' => $request->capacidad
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'vehiculo creado correctamente',
            'data'    => $vehiculo
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Buscar el vehiculo por ID
        $vehiculo = Vehiculo::where('id', $id)->firstOrFail();

        $request->validate([
            'placa'        => 'required|string|max:20|unique:vehiculos',
            'modelo'       => 'string|max:20',
            'capacidad'    => 'integer|min:1',
        ]);

        // Actualizar cada campo de manera explícita
        $vehiculo->update([
            'placa'      => $request->placa,
            'modelo'    => $request->modelo,
            'capacidad' => $request->capacidad
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Vehiculo actualizado correctamente',
            'data'    => $vehiculo
        ]);
    }

}
