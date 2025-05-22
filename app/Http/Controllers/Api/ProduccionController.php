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
        $producciones = Produccion::with(['insumos', 'proceso', 'producto', 'user'])->get();

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
            'active_step' => 'integer',
            'producto_id' => 'required|integer|exists:productos,id',
            'user_id' => 'required|integer|exists:users,id',
            'proceso_id' => 'required|integer|exists:procesos,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Get the proceso steps from the referenced proceso
        $proceso = \App\Models\Proceso::find($request->proceso_id);
        $proceso_steps_copy = $proceso ? $proceso->steps : null;
        if (is_object($proceso_steps_copy)) {
            $proceso_steps_copy = json_decode(json_encode($proceso_steps_copy), true);
        }
        $produccionData = $request->all();
        $produccionData['proceso_steps_copy'] = $proceso_steps_copy;
        $produccion = Produccion::with(['insumos', 'proceso', 'producto', 'user'])->create($produccionData);

        // // Attach insumos from proceso to produccion
        // if ($proceso && $proceso->insumos) {
        //     $insumos = json_decode($proceso->insumos, true);
        //     foreach ($insumos as $insumo) {
        //         if (isset($insumo['insumo_id'], $insumo['quantity'])) {
        //             $produccion->insumos()->attach($insumo['insumo_id'], [
        //                 'cantidad_usada' => $insumo['quantity'],
        //                 'precio_unitario' => 0 // Set to 0 or fetch latest price if needed
        //             ]);
        //         }
        //     }
        // }

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
        $produccion = Produccion::with(['insumos', 'proceso', 'producto', 'user'])->find($id);

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
        $produccion = Produccion::with(['insumos', 'proceso', 'producto', 'user'])->find($id);

        if (!$produccion) {
            return response()->json([
                'success' => false,
                'message' => 'Producción no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'fecha' => 'date',
            'cantidad' => 'integer',
            'active_step' => 'integer',
            'producto_id' => 'integer|exists:productos,id',
            'user_id' => 'integer|exists:users,id',
            'proceso_id' => 'integer|exists:procesos,id',
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
        $produccion = Produccion::with(['insumos', 'proceso', 'producto', 'user'])->find($id);

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

    /**
     * Clear all insumos from a produccion (detach all from pivot table).
     */
    public function clearInsumos($produccionId)
    {
        $produccion = Produccion::find($produccionId);
        if (!$produccion) {
            return response()->json([
                'success' => false,
                'message' => 'Producción no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }
        $produccion->insumos()->detach();
        return response()->json([
            'success' => true,
            'message' => 'Insumos eliminados de la producción',
        ], Response::HTTP_OK);
    }

    /**
     * Update only the proceso_steps_copy for a produccion (PUT /api/produccion/{produccion_id}/steps)
     */
    public function updateSteps(Request $request, $produccionId)
    {
        $validator = Validator::make($request->all(), [
            'proceso_steps_copy' => 'required|array',
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

        $produccion->proceso_steps_copy = $request->proceso_steps_copy;
        $produccion->save();

        return response()->json([
            'success' => true,
            'message' => 'proceso_steps_copy actualizado con éxito',
            'data' => $produccion,
        ], Response::HTTP_OK);
    }
}
