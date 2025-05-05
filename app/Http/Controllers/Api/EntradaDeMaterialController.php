<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EntradaDeMaterial;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class EntradaDeMaterialController extends Controller
{
    /**
     * Mostrar todas las entradas de material.
     */
    public function index()
    {
        $entradas = EntradaDeMaterial::with('insumo')->get();

        return response()->json([
            'success' => true,
            'data' => $entradas,
        ], Response::HTTP_OK);
    }

    /**
     * Crear una nueva entrada de material.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'cantidad' => 'required|numeric|min:1',
            'insumos_id' => 'required|exists:insumos,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entrada = EntradaDeMaterial::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $entrada,
            'message' => 'Entrada de material creada exitosamente',
        ], Response::HTTP_CREATED);
    }

    /**
     * Mostrar una entrada de material específica.
     */
    public function show(string $id)
    {
        $entrada = EntradaDeMaterial::with('insumo')->find($id);

        if (!$entrada) {
            return response()->json([
                'success' => false,
                'message' => 'Entrada de material no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $entrada,
        ], Response::HTTP_OK);
    }

    /**
     * Actualizar una entrada de material existente.
     */
    public function update(Request $request, string $id)
    {
        $entrada = EntradaDeMaterial::find($id);

        if (!$entrada) {
            return response()->json([
                'success' => false,
                'message' => 'Entrada de material no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'cantidad' => 'required|numeric|min:1',
            'insumos_id' => 'required|exists:insumos,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entrada->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $entrada,
            'message' => 'Entrada de material actualizada exitosamente',
        ], Response::HTTP_OK);
    }

    /**
     * Eliminar una entrada de material.
     */
    public function destroy(string $id)
    {
        $entrada = EntradaDeMaterial::find($id);

        if (!$entrada) {
            return response()->json([
                'success' => false,
                'message' => 'Entrada de material no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        $entrada->delete();

        return response()->json([
            'success' => true,
            'message' => 'Entrada de material eliminada exitosamente',
        ], Response::HTTP_OK);
    }
}
