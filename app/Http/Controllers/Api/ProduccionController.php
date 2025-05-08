<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produccion;
use App\Models\EntradaDeMaterial;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $producciones = Produccion::with(['insumos', 'procesos', 'producto', 'user'])->get();

        return response()->json([
            'success' => true,
            'data' => $producciones,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'cantidad' => 'required|integer',
            'producto_id' => 'required|integer|exists:productos,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $produccion = Produccion::with(['insumos', 'procesos', 'producto', 'user'])->create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Producción creada con éxito',
            'data' => $produccion,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produccion = Produccion::with(['insumos', 'procesos', 'producto', 'user'])->find($id);

        if (!$produccion) {
            return response()->json([
                'success' => false,
                'message' => 'Producción no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $produccion,
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produccion = Produccion::with(['insumos', 'procesos', 'producto', 'user'])->find($id);

        if (!$produccion) {
            return response()->json([
                'success' => false,
                'message' => 'Producción no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'cantidad' => 'required|integer',
            'producto_id' => 'required|integer|exists:productos,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $produccion->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Producción actualizada con éxito',
            'data' => $produccion,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produccion = Produccion::with(['insumos', 'procesos', 'producto', 'user'])->find($id);

        if (!$produccion) {
            return response()->json([
                'success' => false,
                'message' => 'Producción no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        $produccion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producción eliminada con éxito',
        ], Response::HTTP_OK);
    }

    /**
     * Add an insumo to a produccion.
     */
    public function addInsumo(Request $request, $produccionId)
    {
        $validator = Validator::make($request->all(), [
            'insumo_id' => 'required|exists:insumos,id',
            'cantidad_usada' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $produccion = Produccion::find($produccionId);

        if (!$produccion) {
            return response()->json([
                'success' => false,
                'message' => 'Producción no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        // Get the last EntradaDeMaterial entry for the given insumo_id
        $entradaDeMaterial = EntradaDeMaterial::where('insumo_id', $request->insumo_id)
            ->orderBy('fecha', 'desc')
            ->first();

        if (!$entradaDeMaterial) {
            return response()->json([
                'success' => false,
                'message' => 'No hay entradas de material para este insumo',
            ], Response::HTTP_NOT_FOUND);
        }

        // Calculate precio_unitario from the last EntradaDeMaterial
        $precio_unitario = $entradaDeMaterial->precio_unitario;

        // Attach the insumo to the produccion with the pivot data
        $produccion->insumos()->attach($request->insumo_id, [
            'cantidad_usada' => $request->cantidad_usada,
            'precio_unitario' => $precio_unitario,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Insumo agregado a la producción exitosamente',
        ], Response::HTTP_OK);
    }
}
