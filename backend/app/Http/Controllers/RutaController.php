<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 'success', 'data' => Ruta::all()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'     => 'required|string|max:100',
            'origen'     => 'required|string|max:255',
            'destino'    => 'required|string|max:255',
            'distancia'  => 'nullable|numeric',
        ]);

        $ruta = Ruta::create($data);
        return response()->json(['status' => 'success', 'message' => 'Ruta creada', 'data' => $ruta], 201);
    }

    public function update(Request $request, Ruta $ruta)
    {
        $data = $request->validate([
            'nombre'     => 'sometimes|string|max:100',
            'origen'     => 'sometimes|string|max:255',
            'destino'    => 'sometimes|string|max:255',
            'distancia'  => 'nullable|numeric',
        ]);

        $ruta->update($data);
        return response()->json(['status' => 'success', 'message' => 'Ruta actualizada', 'data' => $ruta]);
    }

    public function destroy(Ruta $ruta)
    {
        $ruta->delete();
        return response()->json(['status' => 'success', 'message' => 'Ruta eliminada']);
    }
}
