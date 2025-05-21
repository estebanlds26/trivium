<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proceso;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProcesoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $procesos = Proceso::all();

        return response()->json([
            'success' => true,
            'data' => $procesos,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'steps' => 'required|array',
            'insumos' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $request->only(['nombre', 'descripcion', 'steps', 'insumos']);
        $proceso = Proceso::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Proceso creado con éxito',
            'data' => $proceso,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $proceso = Proceso::find($id);

        if (!$proceso) {
            return response()->json([
                'success' => false,
                'message' => 'Proceso no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $proceso,
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $proceso = Proceso::find($id);

        if (!$proceso) {
            return response()->json([
                'success' => false,
                'message' => 'Proceso no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'steps' => 'sometimes|required|array',
            'insumos' => 'sometimes|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $proceso->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Proceso actualizado con éxito',
            'data' => $proceso,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proceso = Proceso::find($id);

        if (!$proceso) {
            return response()->json([
                'success' => false,
                'message' => 'Proceso no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $proceso->delete();

        return response()->json([
            'success' => true,
            'message' => 'Proceso eliminado con éxito',
        ], Response::HTTP_OK);
    }
}
