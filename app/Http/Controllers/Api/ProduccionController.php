<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produccion;
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
        $producciones = Produccion::all();

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

        $produccion = Produccion::create($request->all());

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
        $produccion = Produccion::find($id);

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
        $produccion = Produccion::find($id);

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
        $produccion = Produccion::find($id);

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
}
