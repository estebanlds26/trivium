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
        $producciones = Produccion::with(['insumos', 'procesos', 'producto'])->get();

        return response()->json([
            'success' => true,
            'data' => $producciones,
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produccion = Produccion::with(['insumos', 'procesos', 'producto'])->find($id);

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
}