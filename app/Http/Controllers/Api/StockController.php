<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    /**
     * Listar todos los registros de stock.
     */
    public function index()
    {
        $stocks = Stock::with(['insumo', 'producto'])->get();

        return response()->json([
            'success' => true,
            'data' => $stocks,
        ], Response::HTTP_OK);
    }

    /**
     * Almacenar un nuevo registro de stock.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1',
            'insumos_id' => 'required|exists:insumos,id',
            'productos_id' => 'required|exists:productos,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $stock = Stock::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $stock,
            'message' => 'Registro de stock creado exitosamente',
        ], Response::HTTP_CREATED);
    }

    /**
     * Mostrar un registro de stock específico.
     */
    public function show(string $id)
    {
        $stock = Stock::with(['insumo', 'producto'])->find($id);

        if (!$stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stock no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $stock,
        ], Response::HTTP_OK);
    }

    /**
     * Actualizar un registro de stock existente.
     */
    public function update(Request $request, string $id)
    {
        $stock = Stock::find($id);

        if (!$stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stock no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1',
            'insumos_id' => 'required|exists:insumos,id',
            'productos_id' => 'required|exists:productos,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $stock->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $stock,
            'message' => 'Stock actualizado exitosamente',
        ], Response::HTTP_OK);
    }

    /**
     * Eliminar un registro de stock.
     */
    public function destroy(string $id)
    {
        $stock = Stock::find($id);

        if (!$stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stock no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $stock->delete();

        return response()->json([
            'success' => true,
            'message' => 'Stock eliminado exitosamente',
        ], Response::HTTP_OK);
    }
}
