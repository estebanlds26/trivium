<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::with(['productos', 'user'])->get();

        return response()->json([
            'success' => true,
            'data' => $pedidos,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'estado' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $pedido = Pedido::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $pedido,
            'message' => 'Pedido creado exitosamente',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pedido = Pedido::with(['productos', 'user'])->find($id);

        if (!$pedido) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $pedido,
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'fecha' => 'sometimes|required|date',
            'estado' => 'sometimes|required|string|max:255',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Error de validación',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $pedido->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $pedido,
            'message' => 'Pedido actualizado exitosamente',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $pedido->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pedido eliminado exitosamente',
        ], Response::HTTP_OK);
    }

    /**
     * Add a product to the specified pedido.
     */
    public function addProduct(Request $request, $pedidoId)
    {
        $validator = Validator::make($request->all(), [
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'importe' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $pedido = Pedido::find($pedidoId);

        if (!$pedido) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $pedido->productos()->attach($request->producto_id, [
            'cantidad' => $request->cantidad,
            'importe' => $request->importe,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al pedido exitosamente',
        ], Response::HTTP_OK);
    }
}
