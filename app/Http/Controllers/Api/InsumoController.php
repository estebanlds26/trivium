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
        $insumos = Insumo::with(['producciones'])->get();

        return response()->json([
            'success' => true,
            'data' => $insumos,
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $insumo = Insumo::with(['producciones'])->find($id);

        if (!$insumo) {
            return response()->json([
                'success' => false,
                'message' => 'Insumo no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $insumo,
        ], Response::HTTP_OK);
    }
}