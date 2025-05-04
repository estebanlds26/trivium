<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Insumo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class InsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $insumos = Insumo::all();
        return response()->json([
            'success' => true,
            'data' => $insumos
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'unidad' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $insumo = Insumo::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $insumo,
            'message' => 'Insumo creado correctamente'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $insumo = Insumo::find($id);

        if (!$insumo) {
            return response()->json([
                'success' => false,
                'message' => 'Insumo no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $insumo
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $insumo = Insumo::find($id);

        if (!$insumo) {
            return response()->json([
                'success' => false,
                'message' => 'Insumo no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'unidad' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $insumo->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $insumo,
            'message' => 'Insumo actualizado correctamente'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $insumo = Insumo::find($id);

        if (!$insumo) {
            return response()->json([
                'success' => false,
                'message' => 'Insumo no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        $insumo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Insumo eliminado correctamente'
        ], Response::HTTP_OK);
    }
}
