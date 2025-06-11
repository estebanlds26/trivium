<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EntradaDeMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntradaDeMaterialController extends Controller
{
    /**
     * Mostrar todas las entradas de material.
     */
    public function index()
    {
        $entradas = EntradaDeMaterial::with('insumo')->get();
        return response()->json(['success' => true, 'data' => $entradas]);
    }

    /**
     * Crear una nueva entrada de material.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if (empty($data['fecha'])) {
            $data['fecha'] = now()->toDateString();
        }
        $validator = Validator::make($data, [
            'fecha' => 'required|date',
            'cantidad' => 'required|numeric|min:1',
            'insumo_id' => 'required|exists:insumos,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 422);
        }
        $entrada = EntradaDeMaterial::create($data);
        $entrada->load('insumo');
        return response()->json(['success' => true, 'data' => $entrada], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entrada = EntradaDeMaterial::with('insumo')->find($id);
        if (!$entrada) {
            return response()->json(['success' => false, 'message' => 'Entrada de material no encontrada'], 404);
        }
        return response()->json(['success' => true, 'data' => $entrada]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entrada = EntradaDeMaterial::find($id);
        if (!$entrada) {
            return response()->json(['success' => false, 'message' => 'Entrada de material no encontrada'], 404);
        }
        $validator = Validator::make($request->all(), [
            'fecha' => 'date',
            'cantidad' => 'numeric|min:1',
            'insumo_id' => 'exists:insumos,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 422);
        }
        $entrada->update($request->all());
        $entrada->load('insumo');
        return response()->json(['success' => true, 'data' => $entrada]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entrada = EntradaDeMaterial::find($id);
        if (!$entrada) {
            return response()->json(['success' => false, 'message' => 'Entrada de material no encontrada'], 404);
        }
        $entrada->delete();
        return response()->json(['success' => true, 'message' => 'Entrada de material eliminada con éxito']);
    }
}
